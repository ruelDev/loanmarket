<?php

namespace App\Console\Commands;

use App\Models\FixedRate;
use Promisese\settle;
use GuzzleHttp\Client;
use App\Models\LenderRates;
use App\Models\VariableRate;
use GuzzleHttp\Promise\Utils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Mockery\Undefined;

class FetchLenderRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:lender-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch lender rates with API and store in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $api = [
            [
                'name' => 'CBA',
                'link' => 'https://api.commbank.com.au/public/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
                'version' => '3',
            ],
            [
                'name' => 'Macquarie',
                'link' => 'https://api.macquariebank.io/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
                'version' => '4',
            ],
            [
                'name' => 'St. George',
                'link' => 'https://digital-api.stgeorge.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
                'version' => '3',
            ],
        ];

        $client = new Client();
        $promises = [];

        foreach ($api as $key => $item) {
            Log::info('API Request:', ['api' => $item['link']]);
            $apiName = $item['name'];
            $promises[$key] = $client->getAsync($item['link'], [
                'headers' => [
                    'Authorization' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-v' => $item['version']
                ]
            ])
            ->then(function ($response) use($key, $client, $apiName){

                if($response->getStatusCode() == 200) {
                    $data = json_decode($response->getBody(), true);
                    $products = $data['data']['products'] ?? [];
                    switch($apiName) {
                        case 'CBA':
                            foreach ($products as $product) {
                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;

                                if ($productId) {
                                    Log::info("Fetching details for Product ID: {$productId}");

                                    $client->getAsync("https://api.commbank.com.au/public/cds-au/v1/banking/products/{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => 4
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {

                                                    if(
                                                        in_array($lendingRate['loanPurpose'], ['INVESTMENT', 'OWNER_OCCUPIED'])
                                                        && ($lendingRate['repaymentType'] === 'PRINCIPAL_AND_INTEREST')
                                                    ) {
                                                        $rate = $lendingRate['rate'] ?? null;
                                                        $type = $lendingRate['lendingRateType'] ?? null;
                                                        $purpose = $lendingRate['loanPurpose'] ?? null;
                                                        $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                        $repaymentType = $lendingRate['repaymentType'] ?? null;

                                                        if (
                                                            $type == 'VARIABLE'
                                                            // && isset($lendingRate['tiers'])
                                                        ) {
                                                            if(isset($lendingRate['tiers'])) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    if($tier['name'] !== 'LVR') continue;
                                                                    try {
                                                                        VariableRate::insert([
                                                                            [
                                                                                'lender_id' => 1,
                                                                                'productID' => $productId,
                                                                                'loan_rate' => $rate,
                                                                                'comparison_rate' => $comparisonRate,
                                                                                'loan_purpose' => $purpose,
                                                                                'loan_type' => $type,
                                                                                'repayment_type' => $repaymentType,
                                                                                'tier_name' => $tier['name'],
                                                                                'tier_min' => $tier['minimumValue'],
                                                                                'tier_max' => $tier['maximumValue'],
                                                                                'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                                'created_at' => now(),
                                                                                'updated_at' => now(),
                                                                            ],
                                                                        ]);
                                                                    }
                                                                    catch (\Exception $e) {
                                                                        Log::error('Error Inserting Variable Rate', ['error' => $e->getMessage()]);
                                                                    }
                                                                }
                                                            }
                                                            else {
                                                                try {
                                                                    VariableRate::insert([
                                                                        [
                                                                            'lender_id' => 1,
                                                                            'productID' => $productId,
                                                                            'loan_rate' => $rate,
                                                                            'comparison_rate' => $comparisonRate,
                                                                            'loan_purpose' => $purpose,
                                                                            'loan_type' => $type,
                                                                            'repayment_type' => $repaymentType,
                                                                            'tier_name' => null,
                                                                            'tier_min' => null,
                                                                            'tier_max' => null,
                                                                            'tier_unitOfMeasure' => null,
                                                                            'created_at' => now(),
                                                                            'updated_at' => now(),
                                                                        ],
                                                                    ]);
                                                                }
                                                                catch (\Exception $e) {
                                                                    Log::error('Error Inserting Variable Rate', ['error' => $e->getMessage()]);
                                                                }
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED') {
                                                            preg_match('/\d+/', $lendingRate['additionalValue'] ?? '', $matches);
                                                            $term = $matches[0] ?? null;

                                                            if(isset($lendingRate['tiers'])) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    try {
                                                                        FixedRate::insert([
                                                                            [
                                                                                'lender_id' => 1,
                                                                                'productID' => $productId,
                                                                                'loan_rate' => $rate,
                                                                                'loan_term' => $term,
                                                                                'comparison_rate' => $comparisonRate,
                                                                                'loan_purpose' => $purpose,
                                                                                'loan_type' => $type,
                                                                                'repayment_type' => $repaymentType,
                                                                                'tier_name' => $tier['name'],
                                                                                'tier_min' => $tier['minimumValue'],
                                                                                'tier_max' => $tier['maximumValue'],
                                                                                'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                                'created_at' => now(),
                                                                                'updated_at' => now(),
                                                                            ],
                                                                        ]);
                                                                    }
                                                                    catch (\Exception $e) {
                                                                        Log::error('Error Inserting Fixed Rate', ['error' => $e->getMessage()]);
                                                                    }
                                                                }
                                                            }
                                                            else {
                                                                try {
                                                                    FixedRate::insert([
                                                                        [
                                                                            'lender_id' => 1,
                                                                            'productID' => $productId,
                                                                            'loan_rate' => $rate,
                                                                            'loan_term' => $term,
                                                                            'comparison_rate' => $comparisonRate,
                                                                            'loan_purpose' => $purpose,
                                                                            'loan_type' => $type,
                                                                            'repayment_type' => $repaymentType,
                                                                            'tier_name' => null,
                                                                            'tier_min' => null,
                                                                            'tier_max' => null,
                                                                            'tier_unitOfMeasure' => null,
                                                                            'created_at' => now(),
                                                                            'updated_at' => now(),
                                                                        ],
                                                                    ]);
                                                                }
                                                                catch (\Exception $e) {
                                                                    Log::error('Error Inserting Fixed Rate', ['error' => $e->getMessage()]);
                                                                }
                                                            }
                                                        }
                                                    }
                                                    else continue;
                                                }
                                            }
                                            else {
                                                Log::warning('Product Details Fetch Failed', ['productId' => $productId]);
                                            }
                                        })
                                        ->wait(); // Ensure synchronous wait to prevent request exhaustion
                                }
                            }
                        break;
                        case 'Macquarie':
                            foreach ($products as $product) {
                                if($product['productId'] !== 'LN001MBLBAS001') break;

                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;

                                if ($productId) {
                                    Log::info("Fetching details for Product ID: {$productId}");

                                    $client->getAsync("https://api.macquariebank.io/cds-au/v1/banking/products/{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => 4
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {

                                                    if(
                                                        in_array($lendingRate['loanPurpose'], ['INVESTMENT', 'OWNER_OCCUPIED'])
                                                        && ($lendingRate['repaymentType'] === 'PRINCIPAL_AND_INTEREST')
                                                    ) {
                                                        $rate = $lendingRate['rate'] ?? null;
                                                        $type = $lendingRate['lendingRateType'] ?? null;
                                                        $purpose = $lendingRate['loanPurpose'] ?? null;
                                                        $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                        $repaymentType = $lendingRate['repaymentType'] ?? null;

                                                        if ($type == 'VARIABLE' && isset($lendingRate['tiers']))
                                                        {
                                                            foreach ($lendingRate['tiers'] as $tier) {
                                                                $tierName =  str_contains($tier['name'], 'LVR') ? 'LVR': null;

                                                                if($tierName !== 'LVR') continue;

                                                                try {
                                                                    VariableRate::insert([
                                                                        [
                                                                            'lender_id' => 2,
                                                                            'productID' => $productId,
                                                                            'loan_rate' => $rate,
                                                                            'comparison_rate' => $comparisonRate,
                                                                            'loan_purpose' => $purpose,
                                                                            'loan_type' => $type,
                                                                            'repayment_type' => $repaymentType,
                                                                            'tier_name' => $tierName,
                                                                            'tier_min' => $tier['minimumValue'],
                                                                            'tier_max' => $tier['maximumValue'],
                                                                            'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                            'created_at' => now(),
                                                                            'updated_at' => now(),
                                                                        ],
                                                                    ]);
                                                                }
                                                                catch (\Exception $e) {
                                                                    Log::error('Error Inserting Variable Rate', ['error' => $e->getMessage()]);
                                                                }
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED' && isset($lendingRate['tiers'])) {
                                                            preg_match('/\d+/', $lendingRate['additionalValue'] ?? '', $matches);
                                                            $term = $matches[0] ?? null;

                                                            foreach ($lendingRate['tiers'] as $tier) {
                                                                $tierName =  str_contains($tier['name'], 'LVR') ? 'LVR': null;


                                                                try {
                                                                    FixedRate::insert([
                                                                        [
                                                                            'lender_id' => 2,
                                                                            'productID' => $productId,
                                                                            'loan_rate' => $rate,
                                                                            'loan_term' => $term,
                                                                            'comparison_rate' => $comparisonRate,
                                                                            'loan_purpose' => $purpose,
                                                                            'loan_type' => $type,
                                                                            'repayment_type' => $repaymentType,
                                                                            'tier_name' => $tierName,
                                                                            'tier_min' => $tier['minimumValue'],
                                                                            'tier_max' => $tier['maximumValue'],
                                                                            'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                            'created_at' => now(),
                                                                            'updated_at' => now(),
                                                                        ],
                                                                    ]);
                                                                }
                                                                catch (\Exception $e) {
                                                                    Log::error('Error Inserting Fixed Rate', ['error' => $e->getMessage()]);
                                                                }
                                                            }
                                                        }
                                                    }
                                                    else continue;
                                                }
                                            }
                                            else {
                                                Log::warning('Product Details Fetch Failed', ['productId' => $productId]);
                                            }
                                        })
                                        ->wait(); // Ensure synchronous wait to prevent request exhaustion
                                }
                            }
                        break;
                        case 'St. George':
                            foreach ($products as $product) {
                                if(!in_array($product['productId'], ['STGHLFixedRate', 'STGHLBasic'])) continue;

                                $productId = $product['productId'];
                                $productName = $product['name'];

                                Log::info("Fetching details for Product ID: {$productId}");

                                    $client->getAsync("https://digital-api.stgeorge.com.au/cds-au/v1/banking/products/{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => 4
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName) {
                                            if ($productResponse->getStatusCode() === 200) {

                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {
                                                    $type = $lendingRate['lendingRateType'] ?? null;
                                                    $rate = $lendingRate['rate'] ?? null;
                                                    $purpose = $lendingRate['loanPurpose'] ?? null;
                                                    $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                    $repaymentType = $lendingRate['repaymentType'] ?? null;

                                                    if(
                                                        in_array($lendingRate['loanPurpose'], ['INVESTMENT', 'OWNER_OCCUPIED'])
                                                        && ($lendingRate['repaymentType'] === 'PRINCIPAL_AND_INTEREST')
                                                    ) {
                                                        if($productId === 'STGHLFixedRate' && $type === 'FIXED') {

                                                            preg_match('/\d+/', $lendingRate['additionalValue'] ?? '', $matches);
                                                            $term = $matches[0] ?? null;

                                                            if(isset($lendingRate['tiers'])) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    $tierName =  str_contains($tier['name'], 'LVR') ? 'LVR'
                                                                        : (str_contains($tier['name'], 'LVR') ? 'BALANCE' : null);
                                                                    try {
                                                                        FixedRate::insert([
                                                                            [
                                                                                'lender_id' => 3,
                                                                                'productID' => $productId,
                                                                                'loan_rate' => $rate,
                                                                                'loan_term' => $term,
                                                                                'comparison_rate' => $comparisonRate,
                                                                                'loan_purpose' => $purpose,
                                                                                'loan_type' => $type,
                                                                                'repayment_type' => $repaymentType,
                                                                                'tier_name' => $tierName,
                                                                                'tier_min' => $tier['minimumValue'],
                                                                                'tier_max' => $tier['maximumValue'],
                                                                                'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                                'created_at' => now(),
                                                                                'updated_at' => now(),
                                                                            ],
                                                                        ]);
                                                                    }
                                                                    catch (\Exception $e) {
                                                                        Log::error('Error Inserting Fixed Rate', ['error' => $e->getMessage()]);
                                                                    }
                                                                }
                                                            }
                                                            else {
                                                                try {
                                                                    FixedRate::insert([
                                                                        [
                                                                            'lender_id' => 3,
                                                                            'productID' => $productId,
                                                                            'loan_rate' => $rate,
                                                                            'loan_term' => $term,
                                                                            'comparison_rate' => $comparisonRate,
                                                                            'loan_purpose' => $purpose,
                                                                            'loan_type' => $type,
                                                                            'repayment_type' => $repaymentType,
                                                                            'tier_name' => null,
                                                                            'tier_min' => null,
                                                                            'tier_max' => null,
                                                                            'tier_unitOfMeasure' => null,
                                                                            'created_at' => now(),
                                                                            'updated_at' => now(),
                                                                        ],
                                                                    ]);
                                                                }
                                                                catch (\Exception $e) {
                                                                    Log::error('Error Inserting Fixed Rate', ['error' => $e->getMessage()]);
                                                                }
                                                            }

                                                        }

                                                        if (
                                                            $productId === 'STGHLBasic'
                                                            && $type == 'VARIABLE'
                                                            && isset($lendingRate['tiers'])
                                                        ) {
                                                            foreach ($lendingRate['tiers'] as $tier) {
                                                                if(!str_contains($tier['name'], 'LVR')) continue;

                                                                $tierName =  str_contains($tier['name'], 'LVR') ? 'LVR'
                                                                : (str_contains($tier['name'], 'LVR') ? 'BALANCE' : null);

                                                                try {
                                                                    VariableRate::insert([
                                                                        [
                                                                            'lender_id' => 3,
                                                                            'productID' => $productId,
                                                                            'loan_rate' => $rate,
                                                                            'comparison_rate' => $comparisonRate,
                                                                            'loan_purpose' => $purpose,
                                                                            'loan_type' => $type,
                                                                            'repayment_type' => $repaymentType,
                                                                            'tier_name' => $tierName,
                                                                            'tier_min' => $tier['minimumValue'],
                                                                            'tier_max' => $tier['maximumValue'],
                                                                            'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                            'created_at' => now(),
                                                                            'updated_at' => now(),
                                                                        ],
                                                                    ]);
                                                                }
                                                                catch (\Exception $e) {
                                                                    Log::error('Error Inserting Variable Rate', ['error' => $e->getMessage()]);
                                                                }
                                                            }
                                                        }
                                                    }
                                                    else continue;
                                                }
                                            }
                                            else {
                                                Log::warning('Product Details Fetch Failed', ['productId' => $productId]);
                                            }
                                        })
                                        ->wait();
                            }
                        break;
                        default:
                            Log::info("Skipping unsupported rate type: ".$apiName);
                        break;
                    }
                } else {
                    Log::info('API Error', ['error' => $response->getBody(), 'lender_id' => $key + 1]);
                    Log::error('API Error', ['lender_id' => $key + 1]);
                }
            });
        }

        Utils::settle($promises)->wait();

    }
}
