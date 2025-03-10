<?php

namespace App\Http\Controllers;

use App\Models\ROS;
use App\Models\FixedRate;
use App\Models\VariableRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CalculatorController extends Controller
{
    private function calculateVariableEMI ($P, $r, $n) {
        return ($P * $r * pow((1 + $r), $n)) / (pow((1 + $r), $n) - 1);
    }

    private function calculateFixedEMI($P, $r, $n) {
        return ($P * $r * pow((1 + $r), $n)) / (pow((1 + $r), $n) - 1);
    }

    private function calculateLVR($la, $pa) {
        return ($la / $pa) * 100;
    }

    private function variable($request) {
        $property_value = $request->propertyValue;
        $loan_amount = $request->loanAmount;
        $loan_purpose = $request->loanPurpose;
        $LOAN_TERM_YEARS = $request->clientTerm;
        $total_months = $LOAN_TERM_YEARS * 12; // Total Loan Term in Months or default as 360months since loan term is set as default of 30yrs

        $lvr = $this->calculateLVR($loan_amount, $property_value);

        $rates = VariableRate::with('lender')
            ->select(
                '*',
                DB::raw("
                    $loan_amount * (loan_rate/12) * (POWER(1 + (loan_rate/12), $total_months))
                    / (POWER(1 + (loan_rate/12), $total_months) - 1) AS monthly_payment
                ")
            )
            ->when($loan_amount < 150000, function ($query) use ($lvr) {
                return $query->where(function ($q) use ($lvr) {
                    // Apply LVR filter only to non-CBA lenders
                    $q->whereHas('lender', function ($subQuery) {
                        $subQuery->where('name', '!=', 'CBA');
                    })->where(function ($q) use ($lvr) {
                        $q->where('tier_min', '<=', $lvr)
                          ->where('tier_max', '>=', $lvr);
                    });

                    // Allow CBA only if 'with_package' is NULL
                    $q->orWhereHas('lender', function ($subQuery) {
                        $subQuery->where('name', 'CBA')
                                 ->whereNull('with_package');
                    });
                });
            })
            ->when($loan_amount >= 200000, function ($query) use ($lvr) {
                return $query->where('tier_min', '<=', $lvr)
                    ->where('tier_max', '>=', $lvr);
            })
            ->where('repayment_type', 'PRINCIPAL_AND_INTEREST')
            ->where('loan_purpose', $loan_purpose)
            // ->where(function ($query) use ($lvr) {
            //     $query->where('tier_min', '<=', $lvr)
            //         ->where('tier_max', '>=', $lvr);
            // })
            ->orderBy('monthly_payment', 'asc')
            ->get();

        $uniqueLenders = [];
        $top = [];

        foreach ($rates as $rate) {
            if (!in_array($rate->lender_id, $uniqueLenders)) {
                $uniqueLenders[] = $rate->lender_id;

                $client_variable_interest_rate = $request->clientRate;
                $client_var_monthly_rate = ($client_variable_interest_rate / 100 ) / 12;

                $variable_interest_rate = $rate->loan_rate; // for variable ( depends on the LVR computation )
                $var_monthly_rate = $variable_interest_rate / 12;  // Variable Monthly Interest Rate

                // Monthly payment for variable rate loan
                $variable_monthly_payment =  $this->calculateVariableEMI($loan_amount, $var_monthly_rate, $total_months);
                $client_variable_monthly_payment = $this->calculateVariableEMI($loan_amount, $client_var_monthly_rate, $total_months);

                // Total repayments for the whole loan period
                $total_repayment = $variable_monthly_payment * $total_months;
                $client_total_repayment = $client_variable_monthly_payment * $total_months;

                $savings = $client_total_repayment - $total_repayment;

                // Total interest paid over the loan period
                $total_interest_paid = $total_repayment - $loan_amount;

                array_push($top, [
                    'propertyAddress' => $request->propertyAddress,
                    'propertyValue' => $request->propertyValue,
                    'lender' => $rate->lender['name'],
                    'logo' => $rate->lender['logo'],
                    'lender_id' => count($top) + 1,
                    'monthly' => ceil($rate->monthly_payment),
                    'rate' => number_format($rate->loan_rate  * 100, 2),
                    'comparison' => number_format($rate->comparison_rate  * 100, 2),
                    'term' => $LOAN_TERM_YEARS,
                    'type' => 'Variable',
                    'savings' => ceil($savings),
                    // 'clientEmi' => $client_total_repayment
                ]);
            }

            if (count($top) === 25) break;
        }

        usort($top, function ($a, $b) {
            return $b['savings'] <=> $a['savings'];
        });

        Session::put('top_lenders', $top);
        return $top;
    }

    private function fixed($request) {

        $property_value = $request->propertyValue; // input property value field
        $loan_amount = $request->loanAmount; // input loan amount field
        $loan_term_years = $request->clientTerm; // default 30 years
        $fixed_term_years = $request->loanTerm; // depends on the dropdown
        $total_months = $loan_term_years * 12; // Total Loan Term in Months
        $fixed_term_months = $fixed_term_years * 12; // Fixed Term in Months
        $loan_purpose = $request->loanPurpose;
        $remaining_term_months = $total_months - $fixed_term_months; // Remaining Term in Months

        $rates = FixedRate::with('lender')
            ->select(
                'lender_rates_fixed.lender_id',
                DB::raw("
                    $loan_amount * (loan_rate/12) * (POWER(1 + (loan_rate/12), $total_months))
                    / (POWER(1 + (loan_rate/12), $total_months) - 1) AS monthly_payment
                "),
                'loan_rate',
                'comparison_rate',
                'loan_term',
                'repayment_type'
            )
            ->when($loan_amount < 150000, function ($query) {
                return $query->where(function ($q) {
                    $q->whereDoesntHave('lender', function ($subQuery) {
                        $subQuery->whereIn('name',  ['CBA', 'Heritage Bank']);
                    })->orWhereHas('lender', function ($subQuery) {
                        $subQuery->where('name', 'CBA')
                                 ->whereNull('with_package');
                    });
                });
            })
            ->where('loan_term', $fixed_term_years)
            ->where('loan_purpose', $loan_purpose)
            ->where('repayment_type', 'PRINCIPAL_AND_INTEREST')
            ->orderBy('monthly_payment', 'asc')
            ->get();

        $lvr = $this->calculateLVR($loan_amount, $property_value); // LVR Calculation

        $uniqueLenders = [];
        $top = [];

        foreach($rates as $rate) {
            if (!in_array($rate->lender_id, $uniqueLenders)) {
                $uniqueLenders[] = $rate->lender_id;

                $lender_fixed_rate = $rate->loan_rate; // depends on the dropdown of fixed term years
                $lender_fixed_monthly_rate = $lender_fixed_rate / 12; // Fixed Monthly Interest Rate

                // Monthly payment for first n years (fixed rate, n depends on the fixed term years)
                $lender_fixed_monthly_payment = $rate->monthly_payment;
                $lender_total_fixed_repayment = $lender_fixed_monthly_payment * $fixed_term_months;

                // Remaining balance after 5 years
                $lender_remaining_balance = $loan_amount * pow((1 + $lender_fixed_monthly_rate), $fixed_term_months) - ($lender_fixed_monthly_payment * ((pow((1 + $lender_fixed_monthly_rate), $fixed_term_months) - 1) / $lender_fixed_monthly_rate));

                $variable_rate = VariableRate::with('lender')
                    ->select(
                        '*',
                        DB::raw("
                            $lender_remaining_balance * (loan_rate/12) * (POWER(1 + (loan_rate/12), $remaining_term_months))
                            / (POWER(1 + (loan_rate/12), $remaining_term_months) - 1) AS monthly_payment
                        ")
                    )
                    ->where('loan_purpose', $loan_purpose)
                    ->where(function ($query) use ($lvr) {
                        $query->where('tier_min', '<=', $lvr)
                            ->where('tier_max', '>=', $lvr);
                    })
                    ->where('lender_id', $rate->lender_id)
                    ->orderBy('monthly_payment', 'asc')
                    ->first();

                if($variable_rate === null) continue;

                $lender_variable_monthly_payment = $variable_rate->monthly_payment;
                $lender_total_variable_repayment = $lender_variable_monthly_payment * $remaining_term_months;

                $lender_totalMonthlyRepayments = $lender_total_variable_repayment + $lender_total_fixed_repayment;

                $client_rate = $request->clientRate;
                $client_fixed_monthly_rate = ($client_rate / 100) / 12;
                $client_variable_monthly_rate = (($client_rate  + 0.65) / 100) / 12;

                $client_fixed_monthly_payment = $this->calculateFixedEMI($loan_amount, $client_fixed_monthly_rate, $total_months);
                $client_total_fixed_repayment = $client_fixed_monthly_payment * $fixed_term_months;

                // Remaining balance after 5 years
                $client_remaining_balance = $loan_amount * pow((1 + $client_fixed_monthly_rate), $fixed_term_months) - ($client_fixed_monthly_payment * ((pow((1 + $client_fixed_monthly_rate), $fixed_term_months) - 1) / $client_fixed_monthly_rate));

                $client_variable_monthly_payment = $this->calculateFixedEMI($client_remaining_balance, $client_variable_monthly_rate, $remaining_term_months);
                $client_total_variable_repayment = $client_variable_monthly_payment * $remaining_term_months;

                $client_totalMonthlyRepayments = $client_total_fixed_repayment + $client_total_variable_repayment;
                $savings = $client_totalMonthlyRepayments - $lender_totalMonthlyRepayments;

                array_push($top, [
                    'propertyAddress' => $request->propertyAddress,
                    'propertyValue' => $request->propertyValue,
                    'lender' => $rate->lender['name'],
                    'logo' => $rate->lender['logo'],
                    'lender_id' => count($top) + 1,
                    'monthly' => ceil($rate->monthly_payment),
                    'rate' => number_format($rate->loan_rate  * 100, 2),
                    'comparison' => number_format($rate->comparison_rate  * 100, 2),
                    'term' => $loan_term_years,
                    'type' => 'Fixed',
                    'savings' => ceil($savings),
                ]);
            }

            if (count($top) === 25) break;
        }

        usort($top, function ($a, $b) {
            return $b['savings'] <=> $a['savings'];
        });

        Session::put('top_lenders', $top);
        return $top;
    }

    public function index($url) {
        $data = config('data');
        $rso = ROS::where('url', $url)->first();
        Session::put('rso_email', $rso->email);
        return view('pages.user.calculator', compact(['rso', 'data']));
    }

    public function calculateSavings(Request $request){
        if ($request->loanType === 'FIXED') {
            return response()->json(['data' => $this->fixed($request), 'success' => 'Top 3 fetch successfully.']);
        }
        else {
            return response()->json(['data' => $this->variable($request), 'success' => 'Top 3 fetch successfully.']);
        }
    }

    public function calculateSavingsDefault() {
        $data = config('data');
        return view('pages.user.defaultCalculator', compact(['data']));
    }


    // Given
    // $property_value = 650000; // input property value field
    // $loan_amount = 350000; // input loan amount field
    // $variable_interest_rate = 6.34 / 100; // depends on the LVR computation
    // $loan_term_years = 30; // default 30 years

    // $LVR = calculateLVR($loan_amount, $property_value); // LVR Calculation

    // $variable_monthly_rate = $variable_interest_rate / 12; // Variable Monthly Interest Rate
    // $total_months = $loan_term_years * 12; // Total Loan Term in Months or default as 360months since loan term is set as default of 30yrs

    // Monthly payment for variable rate loan
    // $variable_monthly_payment = calculateVariableEMI($loan_amount, $variable_monthly_rate, $total_months);

    // Total repayments for the whole loan period
    // $total_repayment = $variable_monthly_payment * $total_months;

    // Total interest paid over the loan period
    // $total_interest_paid = $total_repayment - $loan_amount;

    // Output results
    // echo "\nLoan-to-Value Ratio (LVR): " . number_format($LVR, 2);
    // echo "\nVariable Monthly Payment: " . number_format($variable_monthly_payment, 2);
    // echo "\nTotal Repayment for the Whole Loan Period: " . number_format($total_repayment, 2);
    // echo "\nTotal Interest Paid Over the Loan Period: " . number_format($total_interest_paid, 2);


    // public function fixed($request) {
    //     $property_value = 650000; // input property value field
    //     $loan_amount = 350000; // input loan amount field
    //     $fixed_interest_rate = 5.69 / 100; // depends on the dropdown of fixed term years
    //     $variable_interest_rate = 6.34 / 100; // depends on the LVR computation
    //     $loan_term_years = 30; // default 30 years
    //     $fixed_term_years = 5; // depends on the dropdown

    //     $LVR = $this->calculateLVR($loan_amount, $property_value); // LVR Calculation

    //     $fixed_monthly_rate = $fixed_interest_rate / 12; // Fixed Monthly Interest Rate
    //     $variable_monthly_rate = $variable_interest_rate / 12; // Variable Monthly Interest Rate
    //     $total_months = $loan_term_years * 12; // Total Loan Term in Months
    //     $fixed_term_months = $fixed_term_years * 12; // Fixed Term in Months
    //     $remaining_term_months = $total_months - $fixed_term_months; // Remaining Term in Months

    //     // Monthly payment for first n years (fixed rate, n depends on the fixed term years)
    //     $fixed_monthly_payment = $this->calculateFixedEMI($loan_amount, $fixed_monthly_rate, $total_months);
    //     $total_fixed_repayment = $fixed_monthly_payment * $fixed_term_months;

    //     // Remaining balance after 5 years
    //     $remaining_balance = $loan_amount * pow((1 + $fixed_monthly_rate), $fixed_term_months) - ($fixed_monthly_payment * ((pow((1 + $fixed_monthly_rate), $fixed_term_months) - 1) / $fixed_monthly_rate));

    //     // Monthly payment for remaining n years (variable rate, n depends on the 30years-fixed term years)
    //     $variable_monthly_payment = $this->calculateFixedEMI($remaining_balance, $variable_monthly_rate, $remaining_term_months);
    //     $total_variable_repayment = $variable_monthly_payment * $remaining_term_months;

    //     // Compute Total Loan Repayments
    //     $total_loan_repayment = $total_fixed_repayment + $total_variable_repayment;

    // }
}
