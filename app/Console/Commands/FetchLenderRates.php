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
                'link' => 'https://api.commbank.com.au/public/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
                'version' => '3',
            ],
            // [
            //     'link' => 'https://digital-api.stgeorge.com.au/cds-au/v1/banking/products/STGHLFixedRate',
            //     'version' => '4',
            // ]
        ];

        $client = new Client();
        $promises = [];

        foreach ($api as $key => $item) {
            Log::info('API Request:', ['api' => $item['link']]);
            $promises[$key] = $client->getAsync($item['link'], [
                'headers' => [
                    'Authorization' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-v' => $item['version']
                ]
            ])->then(function ($response) use($key, $client){

                if($response->getStatusCode() == 200) {
                    $data = json_decode($response->getBody(), true);
                    $products = $data['data']['products'] ?? [];

                    foreach ($products as $product) {
                        $productId = $product['productId'] ?? null;

                        if ($productId) {
                            Log::info("Fetching details for Product ID: {$productId}");

                            $client->getAsync("https://api.commbank.com.au/public/cds-au/v1/banking/products/{$productId}", [
                                    'headers' => [
                                        'Authorization' => 'application/json',
                                        'Content-Type' => 'application/json',
                                        'x-v' => 4
                                    ]
                                ])
                                ->then(function ($productResponse) use ($productId) {
                                    if ($productResponse->getStatusCode() === 200) {
                                        $productDetails = json_decode($productResponse->getBody(), true);
                                        $lendingRates = $productDetails['data']['lendingRates'] ?? [];
                                        Log::info('Product Details:', ['productId' => $productId, 'lendingRate' => json_encode($lendingRates, JSON_PRETTY_PRINT)]);

                                        foreach ($lendingRates as $lendingRate) {
                                            $rate = $lendingRate['rate'] ?? null;
                                            $type = $lendingRate['lendingRateType'] ?? null;
                                            $purpose = $lendingRate['loanPurpose'] ?? null;
                                            $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                            $repaymentType = $lendingRate['repaymentType'] ?? null;
                                            Log::info('Lending Rate:', ['rate' => $rate, 'type' => $type, 'purpose' => $purpose, 'comparisonRate' => $comparisonRate]);
                                            if ($type == 'VARIABLE') {

                                                if(isset($lendingRate['tiers'])) {
                                                    foreach ($lendingRate['tiers'] as $tier) {
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
                                            else {
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
                                    }
                                    else {
                                        Log::warning('Product Details Fetch Failed', ['productId' => $productId]);
                                    }
                                })
                                ->wait(); // Ensure synchronous wait to prevent request exhaustion
                        }
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
