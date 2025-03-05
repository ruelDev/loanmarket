<?php

namespace App\Console\Commands;

use Promisese\settle;
use GuzzleHttp\Client;
use Mockery\Undefined;
use App\Models\Lenders;
use App\Models\FixedRate;
use App\Models\LenderRates;
use Illuminate\Support\Str;
use App\Models\VariableRate;
use GuzzleHttp\Promise\Utils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;

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

    public $api = [
        [
            'name' => 'CBA',
            'link' => 'https://api.commbank.com.au/public/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://api.commbank.com.au/public/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/Commonwealth.svg',
        ],
        [
            'name' => 'Macquarie',
            'link' => 'https://api.macquariebank.io/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '4',
            'products_link' => 'https://api.macquariebank.io/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/macquarie.png',
        ],
        [
            'name' => 'St. George',
            'link' => 'https://digital-api.stgeorge.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://digital-api.stgeorge.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/stGeorge.png',
        ],
        [
            'name' => 'Bankwest',
            'link' => 'https://open-api.bankwest.com.au/bwpublic/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://open-api.bankwest.com.au/bwpublic/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/bankwest.png',
        ],
        [
            'name' => 'ANZ',
            'link' => 'https://api.anz/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://api.anz/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/anz.png',
        ],
        [
            'name' => 'NAB',
            'link' => 'https://openbank.api.nab.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://openbank.api.nab.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/nab.png',
        ],
        [
            'name' => 'Westpac',
            'link' => 'https://digital-api.westpac.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://digital-api.westpac.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/westpac.png',
        ],
        [
            'name' => 'Bank Autralia',
            'link' => 'https://public.cdr-api.bankaust.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://public.cdr-api.bankaust.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/bankAustralia.png',
        ],
        [
            'name' => 'Bendigo Bank', #magulo
            'link' => 'https://api.cdr.bendigobank.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://api.cdr.bendigobank.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/bendigoBank.png',
        ],
        [
            'name' => 'Adelaide Bank', #magulo
            'link' => 'https://api.cdr.adelaidebank.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://api.cdr.adelaidebank.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/adelaideBank.png',
        ],
        [
            'name' => 'People\'s Choice',
            'link' => 'https://ob-public.peopleschoice.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://ob-public.peopleschoice.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/peoplesChoice.png',
        ],
        [
            'name' => 'Beyond Bank Australia', #magulo - nasa additional info ang lvr
            'link' => 'https://public.cdr.api.beyondbank.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://public.cdr.api.beyondbank.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/beyondBankAustralia.png',
        ],
        [
            'name' => 'Heritage Bank', # magulo
            'link' => 'https://product.api.heritage.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://product.api.heritage.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/heritageBank.png',
        ],
        [
            'name' => 'Credit Union SA',  #magulo - nasa additional info ang lvr
            'link' => 'https://openbanking.api.creditunionsa.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://openbanking.api.creditunionsa.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/creditUnionSa.png',
        ],
        [
            'name' => 'Bankfirst',
            'link' => 'https://public.cdr.bankfirst.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://public.cdr.bankfirst.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/bankfirst.png',
        ],
        [
            'name' => 'Ubank',
            'link' => 'https://public.cdr-api.86400.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://public.cdr-api.86400.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/ubank.png',
        ],
        [
            'name' => 'BankSA',
            'link' => 'https://digital-api.banksa.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://digital-api.banksa.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/banksa.png',
        ],
        [
            'name' => 'Australian Unity',
            'link' => 'https://open-banking.australianunity.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://open-banking.australianunity.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/australianUnity.png',
        ],
        // [
        //     'name' => 'Defence Bank', #not reading / no error / no logs
        //     'link' => 'https://product.defencebank.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
        //     'version' => '3',
        //     'products_link' => 'https://product.defencebank.com.au/cds-au/v1/banking/products/',
        //     'products_version' => '4',
        //     'logo' => 'assets/images/lenders/stGeorge.png',
        // ],
        [
            'name' => 'P&N Bank',
            'link' => 'https://public.cdr-api.pnbank.com.au/cds-au/v1/banking/products?product-category=RESIDENTIAL_MORTGAGES',
            'version' => '3',
            'products_link' => 'https://public.cdr-api.pnbank.com.au/cds-au/v1/banking/products/',
            'products_version' => '4',
            'logo' => 'assets/images/lenders/pnbank.png',
        ],
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $promises = [];

        $api = $this->api;

        foreach ($api as $key => $item) {
            $apiName = $item['name'];
            $apiLogo = $item['logo'];
            $products_link = $item['products_link'];
            $products_version = $item['products_version'];

            Lenders::insert([
                'name' => $apiName,
                'logo' => $apiLogo
            ]);

            $promises[$key] = $client->getAsync($item['link'], [
                'headers' => [
                    'Authorization' => 'application/json',
                    'Content-Type' => 'application/json',
                    'x-v' => $item['version']
                ]
            ])
            ->then(function ($response) use($key, $client, $apiName, $products_link, $products_version){
                if($response->getStatusCode() == 200) {
                    $id = $key + 1;
                    $data = json_decode($response->getBody(), true);
                    $products = $data['data']['products'] ?? [];
                    switch($apiName) {
                        case 'ANZ':
                        case 'NAB':
                        case 'Bank Autralia':
                        case 'People\'s Choice':
                        case 'Australia Unity':
                            foreach ($products as $product) {
                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;
                                $brand = isset($product['brand']) ? $product['brand'] : (isset($product['brandName']) ? isset($product['brandName']) : null);
                                $isTailored = $product['isTailored'] ?? null;

                                if ($productId) {
                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $id, $description, $productInfo) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {

                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        $rate = $lendingRate['rate'] ?? null;
                                                        $type = $lendingRate['lendingRateType'] ?? null;
                                                        $purpose = $lendingRate['loanPurpose'] ?? null;
                                                        $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                        $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                        $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;

                                                        if ($type == 'VARIABLE') {
                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    if(!str_contains($tier['name'], 'LVR')) continue;

                                                                    $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                    $this->variableWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->variableNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' =>  floatval($comparisonRate),
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED') {
                                                            preg_match('/\d+/', $lendingRate['additionalValue'] ?? '', $matches);
                                                            $term = $matches[0] ?? null;

                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {

                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                    $this->fixedWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_term' => $term,
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->fixedNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' => floatval($comparisonRate),
                                                                    'loan_term' => $term,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
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

                        case 'CBA':
                            foreach ($products as $product) {
                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;
                                $brand = isset($product['brand']) ? $product['brand'] : (isset($product['brandName']) ? isset($product['brandName']) : null);
                                $isTailored = $product['isTailored'] ?? null;

                                if ($productId) {
                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $id, $description, $productInfo) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {

                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        $rate = $lendingRate['rate'] ?? null;
                                                        $type = $lendingRate['lendingRateType'] ?? null;
                                                        $purpose = $lendingRate['loanPurpose'] ?? null;
                                                        $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                        $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                        $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;

                                                        if ($type == 'VARIABLE') {
                                                            if(in_array($productId, ['6c781d6471644fe084847533ab31aca2', 'f1d6fcc359804f3c9365d576c56356fc'])) {
                                                                if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                    foreach ($lendingRate['tiers'] as $tier) {
                                                                        if(!str_contains($tier['name'], 'LVR')) continue;

                                                                        $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                        $this->variableWithTiers([
                                                                            'lender_id' => $id,
                                                                            'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                            'productID' => $productId,
                                                                            'loan_rate' => floatval($rate),
                                                                            'comparison_rate' => floatval($comparisonRate),
                                                                            'loan_purpose' => $purpose,
                                                                            'loan_type' => $type,
                                                                            'repayment_type' => $repaymentType,
                                                                            'tier_name' => $tierName,
                                                                            'tier_min' => $tier['minimumValue'],
                                                                            'tier_max' => $tier['maximumValue'] ?? null,
                                                                            'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                            'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                            'product_name' => $productName,
                                                                            'product_description' => $description,
                                                                            'with_package' => Str::contains($lendingRateAdditionalInfo, 'with Package') ? '150000' : null,
                                                                        ]);
                                                                    }
                                                                }
                                                                else {
                                                                    $this->variableNoTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' =>  floatval($comparisonRate),
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                        'with_package' => Str::contains($lendingRateAdditionalInfo, 'with Package') ? '150000' : null,
                                                                    ]);
                                                                }
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED') {
                                                            preg_match('/\d+/', $lendingRate['additionalValue'] ?? '', $matches);
                                                            $term = $matches[0] ?? null;

                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {

                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                    $this->fixedWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_term' => $term,
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'with_package' => Str::contains($lendingRateAdditionalInfo, 'with Package') ? '150000' : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->fixedNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' => floatval($comparisonRate),
                                                                    'loan_term' => $term,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                    'with_package' => Str::contains($lendingRateAdditionalInfo, 'with Package') ? '150000' : null,
                                                                ]);
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

                        case 'Adelaide Bank':
                            foreach ($products as $product) {
                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;
                                $brand = isset($product['brand']) ? $product['brand'] : (isset($product['brandName']) ? isset($product['brandName']) : null);
                                $isTailored = $product['isTailored'] ?? null;

                                if ($productId) {
                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $id, $description, $productInfo) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {

                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        $rate = $lendingRate['rate'] ?? null;
                                                        $type = $lendingRate['lendingRateType'] ?? null;
                                                        $purpose = $lendingRate['loanPurpose'] ?? null;
                                                        $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                        $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                        $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;

                                                        if ($type == 'VARIABLE') {
                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    if(!str_contains($tier['name'], 'LVR')) continue;

                                                                    $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                    $this->variableWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? '100.00',
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $tier = $this->adelaideLvrMinMax($lendingRateAdditionalInfo);

                                                                $this->variableNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' =>  floatval($comparisonRate),
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => 'LVR',
                                                                    'tier_min' => $tier['min'],
                                                                    'tier_max' => $tier['max'],
                                                                    'tier_unitOfMeasure' => 'PERCENT',
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED') {
                                                            preg_match('/\d+/', $lendingRate['additionalValue'] ?? '', $matches);
                                                            $term = $matches[0] ?? null;

                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {

                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                    $this->fixedWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_term' => $term,
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? '100.00',
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $tier = $this->adelaideLvrMinMax($lendingRateAdditionalInfo);

                                                                $this->fixedNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' => floatval($comparisonRate),
                                                                    'loan_term' => $term,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => 'LVR',
                                                                    'tier_min' => $tier['min'],
                                                                    'tier_max' => $tier['max'],
                                                                    'tier_unitOfMeasure' => 'PERCENT',
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
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

                        case 'Beyond Bank Australia':
                            foreach ($products as $product) {
                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;
                                $brand = isset($product['brand']) ? $product['brand'] : (isset($product['brandName']) ? isset($product['brandName']) : null);
                                $isTailored = $product['isTailored'] ?? null;

                                if ($productId) {
                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $id, $description, $productInfo) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {

                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        $rate = $lendingRate['rate'] ?? null;
                                                        $type = $lendingRate['lendingRateType'] ?? null;
                                                        $purpose = $lendingRate['loanPurpose'] ?? null;
                                                        $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                        $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                        $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;

                                                        if ($type == 'VARIABLE') {
                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    if(!str_contains($tier['name'], 'LVR')) continue;

                                                                    $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                    $this->variableWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? '100.00',
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $tier = $this->beyondBankAusLvrMinMax($lendingRateAdditionalInfo);

                                                                $this->variableNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' =>  floatval($comparisonRate),
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => 'LVR',
                                                                    'tier_min' => $tier['min'],
                                                                    'tier_max' => $tier['max'],
                                                                    'tier_unitOfMeasure' => 'PERCENT',
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED') {
                                                            preg_match('/\d+/', $lendingRate['additionalValue'] ?? '', $matches);
                                                            $term = $matches[0] ?? null;

                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {

                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                    $this->fixedWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_term' => $term,
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? '100.00',
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $tier = $this->beyondBankAusLvrMinMax($lendingRateAdditionalInfo);

                                                                $this->fixedNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' => floatval($comparisonRate),
                                                                    'loan_term' => $term,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => 'LVR',
                                                                    'tier_min' => $tier['min'],
                                                                    'tier_max' => $tier['max'],
                                                                    'tier_unitOfMeasure' => 'PERCENT',
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
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

                        case 'Heritage Bank':
                            foreach ($products as $product) {
                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;
                                $brand = isset($product['brand']) ? $product['brand'] : (isset($product['brandName']) ? isset($product['brandName']) : null);
                                $isTailored = $product['isTailored'] ?? null;

                                if ($productId) {
                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $id, $description, $productInfo) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {

                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        $rate = $lendingRate['rate'] ?? null;
                                                        $type = $lendingRate['lendingRateType'] ?? null;
                                                        $purpose = $lendingRate['loanPurpose'] ?? null;
                                                        $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                        $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                        $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;

                                                        if ($type == 'VARIABLE') {
                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    if(!str_contains($tier['name'], 'LVR')) continue;

                                                                    $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                    $this->variableWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->variableNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' =>  floatval($comparisonRate),
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED') {
                                                            if(in_array($productId, ['afd4e980-5904-4a9f-806c-e45ebd44a563', 'f3ea71d7-2ab2-430a-9f24-8d4aed351125'])) {
                                                                preg_match('/\d+/', $lendingRate['additionalValue'] ?? '', $matches);
                                                                $term = $matches[0] ?? null;

                                                                if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {

                                                                    foreach ($lendingRate['tiers'] as $tier) {
                                                                        $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                        $this->fixedWithTiers([
                                                                            'lender_id' => $id,
                                                                            'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                            'productID' => $productId,
                                                                            'loan_rate' => floatval($rate),
                                                                            'comparison_rate' => floatval($comparisonRate),
                                                                            'loan_term' => $term,
                                                                            'loan_purpose' => $purpose,
                                                                            'loan_type' => $type,
                                                                            'repayment_type' => $repaymentType,
                                                                            'tier_name' => $tierName,
                                                                            'tier_min' => $tier['minimumValue'],
                                                                            'tier_max' => $tier['maximumValue'] ?? null,
                                                                            'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                            'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                            'product_name' => $productName,
                                                                            'product_description' => $description,
                                                                        ]);
                                                                    }
                                                                }
                                                                else {
                                                                    $this->fixedNoTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_term' => $term,
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
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

                        case 'Bankwest':
                        case 'Westpac':
                        case 'Bankfirst':
                            foreach ($products as $product) {
                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;
                                $brand = isset($product['brand']) ? $product['brand'] : (isset($product['brandName']) ? isset($product['brandName']) : null);
                                $isTailored = $product['isTailored'] ?? null;

                                if ($productId) {
                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $id, $description, $productInfo) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {

                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        $rate = $lendingRate['rate'] ?? null;
                                                        $type = $lendingRate['lendingRateType'] ?? null;
                                                        $purpose = $lendingRate['loanPurpose'] ?? null;
                                                        $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                        $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                        $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;

                                                        if ($type == 'VARIABLE') {
                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    if(!str_contains($tier['name'], 'LVR')) continue;

                                                                    $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                    $this->variableWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? '100.00',
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->variableNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' =>  floatval($comparisonRate),
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED') {
                                                            preg_match('/\d+/', $lendingRate['additionalValue'] ?? '', $matches);
                                                            $term = $matches[0] ?? null;

                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {

                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                    $this->fixedWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_term' => $term/12,
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? '100.00',
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->fixedNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' => floatval($comparisonRate),
                                                                    'loan_term' => $term/12,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
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

                        case 'Bendigo Bank':
                            foreach ($products as $product) {
                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;
                                $brand = isset($product['brand']) ? $product['brand'] : (isset($product['brandName']) ? isset($product['brandName']) : null);
                                $isTailored = $product['isTailored'] ?? null;

                                if ($productId) {
                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $id, $description, $productInfo) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {

                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        $rate = $lendingRate['rate'] ?? null;
                                                        $type = $lendingRate['lendingRateType'] ?? null;
                                                        $purpose = $lendingRate['loanPurpose'] ?? null;
                                                        $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                        $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                        $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;
                                                        $lvrMinMax = isset($lendingRate['additionalInfo']) ? $this->bendigoLvrMinMax($lendingRate['additionalInfo']) : ['min' => null, 'max' => null];
                                                        $tierName =  isset($lendingRate['additionalInfo']) ? 'LVR' : null;
                                                        $tierMeasurement = isset($lendingRate['additionalInfo']) ? 'PERCENT' : null;

                                                        if ($type == 'VARIABLE') {
                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    // if(!str_contains($tier['name'], 'LVR')) continue;

                                                                    // $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                    $this->variableWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $lvrMinMax['min'],
                                                                        'tier_max' => $lvrMinMax['max'],
                                                                        'tier_unitOfMeasure' => $tierMeasurement,
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->variableNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' =>  floatval($comparisonRate),
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => $tierName,
                                                                    'tier_min' => $lvrMinMax['min'],
                                                                    'tier_max' => $lvrMinMax['max'],
                                                                    'tier_unitOfMeasure' => $tierMeasurement,
                                                                    'tier_additional_info' => null,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED') {
                                                            preg_match('/\d+/', $lendingRate['additionalValue'] ?? '', $matches);
                                                            $term = $matches[0] ?? null;

                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {

                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    // $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                    $this->fixedWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_term' => $term,
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $lvrMinMax['min'],
                                                                        'tier_max' => $lvrMinMax['max'],
                                                                        'tier_unitOfMeasure' => $tierMeasurement,
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->fixedNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' => floatval($comparisonRate),
                                                                    'loan_term' => $term,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => $tierName,
                                                                    'tier_min' => $lvrMinMax['min'],
                                                                    'tier_max' => $lvrMinMax['max'],
                                                                    'tier_unitOfMeasure' => $tierMeasurement,
                                                                    'tier_additional_info' => null,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
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
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;

                                if ($productId) {
                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $productInfo, $description, $id) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {
                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        $rate = $lendingRate['rate'] ?? null;
                                                        $type = $lendingRate['lendingRateType'] ?? null;
                                                        $purpose = $lendingRate['loanPurpose'] ?? null;
                                                        $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                        $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                        $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;

                                                        if ($type == 'VARIABLE' && isset($lendingRate['tiers']))
                                                        {
                                                            foreach ($lendingRate['tiers'] as $tier) {

                                                                $tierName =  $this->tierName($tier['unitOfMeasure']);
                                                                if($tierName !== 'LVR') continue;

                                                                $this->variableWithTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => $rate,
                                                                    'comparison_rate' => $comparisonRate,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => $tierName,
                                                                    'tier_min' => $tier['minimumValue'],
                                                                    'tier_max' => $tier['maximumValue'] ?? null,
                                                                    'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                    'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED' && isset($lendingRate['tiers'])) {
                                                            $term = $this->term($lendingRate['additionalValue']);

                                                            foreach ($lendingRate['tiers'] as $tier) {
                                                                $tierName =  $this->tierName($tier['unitOfMeasure']);

                                                                $this->fixedNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => $rate,
                                                                    'loan_term' => $term,
                                                                    'comparison_rate' => $comparisonRate,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => $tierName,
                                                                    'tier_min' => $tier['minimumValue'],
                                                                    'tier_max' => $tier['maximumValue'] ?? null,
                                                                    'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                    'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
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
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;

                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $productInfo, $description, $id) {
                                            if ($productResponse->getStatusCode() === 200) {

                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {
                                                    $type = $lendingRate['lendingRateType'] ?? null;
                                                    $rate = $lendingRate['rate'] ?? null;
                                                    $purpose = $lendingRate['loanPurpose'] ?? null;
                                                    $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                    $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                    $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;

                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        if($productId === 'STGHLFixedRate' && $type === 'FIXED') {
                                                            $term = $this->term($lendingRate['additionalValue']);

                                                            if(isset($lendingRate['tiers'])) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    $tierName = $this->tierName($tier['unitOfMeasure']);
                                                                    $this->fixedWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => $rate,
                                                                        'loan_term' => $term,
                                                                        'comparison_rate' => $comparisonRate,
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->fixedNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => $rate,
                                                                    'loan_term' => $term,
                                                                    'comparison_rate' => $comparisonRate,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }

                                                        }

                                                        if (
                                                            $productId === 'STGHLBasic'
                                                            && $type == 'VARIABLE'
                                                            && isset($lendingRate['tiers'])
                                                        ) {
                                                            foreach ($lendingRate['tiers'] as $tier) {
                                                                if(!str_contains($tier['name'], 'LVR')) continue;

                                                                $tierName = $this->tierName($tier['unitOfMeasure']);

                                                                $this->variableWithTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => $rate,
                                                                    'comparison_rate' => $comparisonRate,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => $tierName,
                                                                    'tier_min' => $tier['minimumValue'],
                                                                    'tier_max' => $tier['maximumValue'] ?? null,
                                                                    'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                    'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                    } else continue;
                                                }
                                            } else Log::warning('Product Details Fetch Failed', ['productId' => $productId]);
                                        })
                                        ->wait();
                            }
                        break;

                        case 'Credit Union SA':
                            foreach ($products as $product) {
                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;
                                $brand = isset($product['brand']) ? $product['brand'] : (isset($product['brandName']) ? isset($product['brandName']) : null);
                                $isTailored = $product['isTailored'] ?? null;

                                if ($productId) {
                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $description, $id, $productInfo) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {



                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        $rate = $lendingRate['rate'] ?? null;
                                                        $type = $lendingRate['lendingRateType'] ?? null;
                                                        $purpose = $lendingRate['loanPurpose'] ?? null;
                                                        $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                        $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                        $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;

                                                        if ($type == 'VARIABLE') {
                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    if(!str_contains($tier['name'], 'LVR')) continue;

                                                                    $tierName = $this->tierName($tier['unitOfMeasure']);

                                                                    $this->variableWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $tier = $this->creditUnionSALvrMinMax($lendingRateAdditionalInfo);

                                                                $this->variableNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' =>  floatval($comparisonRate),
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => 'LVR',
                                                                    'tier_min' => $tier['min'],
                                                                    'tier_max' => $tier['max'] ?? null,
                                                                    'tier_unitOfMeasure' => 'PERCENT',
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED') {
                                                            $term = $this->creditUnionSATerm($lendingRateAdditionalInfo);

                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {

                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    $tierName = $this->tierName($tier['unitOfMeasure']);

                                                                    $this->fixedWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_term' => $term,
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $tier = $this->creditUnionSALvrMinMax($lendingRateAdditionalInfo);

                                                                $this->fixedNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' => floatval($comparisonRate),
                                                                    'loan_term' => $term,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => 'LVR',
                                                                    'tier_min' => $tier['min'],
                                                                    'tier_max' => $tier['max'] ?? null,
                                                                    'tier_unitOfMeasure' => 'PERCENT',
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                    } else continue;
                                                }
                                            } else Log::warning('Product Details Fetch Failed', ['productId' => $productId]);
                                        })
                                        ->wait(); // Ensure synchronous wait to prevent request exhaustion
                                }
                            }
                        break;

                        case 'Ubank':
                        case 'BankSA':
                            foreach ($products as $product) {
                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;
                                $brand = isset($product['brand']) ? $product['brand'] : (isset($product['brandName']) ? isset($product['brandName']) : null);
                                $isTailored = $product['isTailored'] ?? null;

                                if ($productId) {
                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $description, $id, $productInfo) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {

                                                    $rate = $lendingRate['rate'] ?? null;
                                                    $type = $lendingRate['lendingRateType'] ?? null;
                                                    $purpose = $lendingRate['loanPurpose'] ?? null;
                                                    $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                    $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                    $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;


                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        if ($type == 'VARIABLE') {
                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    if(!$tier['unitOfMeasure']) continue;

                                                                    $tierName = $this->tierName($tier['unitOfMeasure']);

                                                                    $this->variableWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->variableNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' =>  floatval($comparisonRate),
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED') {
                                                            $term = $this->term($lendingRate['additionalValue']);

                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    $this->fixedWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_term' => $term,
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $this->tierName($tier['unitOfMeasure']),
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->fixedNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' => floatval($comparisonRate),
                                                                    'loan_term' => $term,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
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

                        case 'P&N Bank':
                            foreach ($products as $product) {
                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;
                                $brand = isset($product['brand']) ? $product['brand'] : (isset($product['brandName']) ? isset($product['brandName']) : null);
                                $isTailored = $product['isTailored'] ?? null;

                                if ($productId) {
                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $description, $id, $productInfo) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {

                                                    $rate = $lendingRate['rate'] ?? null;
                                                    $type = $lendingRate['lendingRateType'] ?? null;
                                                    $purpose = $lendingRate['loanPurpose'] ?? null;
                                                    $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                    $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                    $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;


                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        if ($type == 'VARIABLE') {
                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    if(!$tier['unitOfMeasure']) continue;

                                                                    $tierName = $this->tierName($tier['unitOfMeasure']);

                                                                    $this->variableWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $tier = $this->pnbankLvrMinMax($productName);

                                                                $this->variableNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' =>  floatval($comparisonRate),
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => 'LVR',
                                                                    'tier_min' => $tier['min'],
                                                                    'tier_max' => $tier['max'] ?? null,
                                                                    'tier_unitOfMeasure' => 'PERCENT',
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED') {
                                                            $term = $this->term($lendingRate['additionalValue']);

                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    $this->fixedWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_term' => $term,
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $this->tierName($tier['unitOfMeasure']),
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $tier = $this->pnbankLvrMinMax($productName);

                                                                $this->fixedNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' => floatval($comparisonRate),
                                                                    'loan_term' => $term,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'tier_name' => 'LVR',
                                                                    'tier_min' => $tier['min'],
                                                                    'tier_max' => $tier['max'] ?? null,
                                                                    'tier_unitOfMeasure' => 'PERCENT',
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
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

                        case 'Defence Bank':
                            foreach ($products as $product) {
                                $productId = $product['productId'] ?? null;
                                $productName = $product['name'] ?? null;
                                $productInfo = $product['additionalInfo'] ?? null;
                                $description = $product['description'] ?? null;
                                $brand = isset($product['brand']) ? $product['brand'] : (isset($product['brandName']) ? isset($product['brandName']) : null);
                                $isTailored = $product['isTailored'] ?? null;

                                if ($productId) {
                                    $client->getAsync("{$products_link}{$productId}", [
                                            'headers' => [
                                                'Authorization' => 'application/json',
                                                'Content-Type' => 'application/json',
                                                'x-v' => $products_version
                                            ]
                                        ])
                                        ->then(function ($productResponse) use ($productId, $productName, $description, $id, $productInfo) {
                                            if ($productResponse->getStatusCode() === 200) {
                                                $productDetails = json_decode($productResponse->getBody(), true);
                                                $lendingRates = $productDetails['data']['lendingRates'] ?? [];

                                                foreach ($lendingRates as $lendingRate) {
                                                    if($this->isLendingRate($lendingRate['loanPurpose'], $lendingRate['repaymentType'])) {
                                                        $rate = $lendingRate['rate'] ?? null;
                                                        $type = $lendingRate['lendingRateType'] ?? null;
                                                        $purpose = $lendingRate['loanPurpose'] ?? null;
                                                        $comparisonRate = $lendingRate['comparisonRate'] ?? 0;
                                                        $repaymentType = $lendingRate['repaymentType'] ?? null;
                                                        $lendingRateAdditionalInfo = isset($lendingRate['additionalInfo']) ? $lendingRate['additionalInfo'] : null;

                                                        if ($type == 'VARIABLE') {
                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    if(!$tier['unitOfMeasure']) continue;

                                                                    $tierName = $this->tierName($tier['unitOfMeasure']);

                                                                    $this->variableWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $tierName,
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->variableNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' =>  floatval($comparisonRate),
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
                                                            }
                                                        }
                                                        elseif ($type == 'FIXED') {
                                                            $term = $this->term($lendingRate['additionalValue']);

                                                            if(isset($lendingRate['tiers']) && (count($lendingRate['tiers']) > 0)) {
                                                                foreach ($lendingRate['tiers'] as $tier) {
                                                                    $this->fixedWithTiers([
                                                                        'lender_id' => $id,
                                                                        'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                        'productID' => $productId,
                                                                        'loan_rate' => floatval($rate),
                                                                        'comparison_rate' => floatval($comparisonRate),
                                                                        'loan_term' => $term,
                                                                        'loan_purpose' => $purpose,
                                                                        'loan_type' => $type,
                                                                        'repayment_type' => $repaymentType,
                                                                        'tier_name' => $this->tierName($tier['unitOfMeasure']),
                                                                        'tier_min' => $tier['minimumValue'],
                                                                        'tier_max' => $tier['maximumValue'] ?? null,
                                                                        'tier_unitOfMeasure' => $tier['unitOfMeasure'],
                                                                        'tier_additional_info' => isset($tier['additionalInfo']) ? $tier['additionalInfo'] : null,
                                                                        'product_name' => $productName,
                                                                        'product_description' => $description,
                                                                    ]);
                                                                }
                                                            }
                                                            else {
                                                                $this->fixedNoTiers([
                                                                    'lender_id' => $id,
                                                                    'lender_rate_additional_info' => $lendingRateAdditionalInfo,
                                                                    'productID' => $productId,
                                                                    'loan_rate' => floatval($rate),
                                                                    'comparison_rate' => floatval($comparisonRate),
                                                                    'loan_term' => $term,
                                                                    'loan_purpose' => $purpose,
                                                                    'loan_type' => $type,
                                                                    'repayment_type' => $repaymentType,
                                                                    'product_name' => $productName,
                                                                    'product_description' => $description,
                                                                ]);
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

                        default:
                            Log::info("Skipping unsupported rate type: ".$apiName);
                        break;
                    }
                }
                else {
                    Log::info('API Error', ['error' => $response->getBody(), 'lender_id' => $key + 1]);
                    Log::error('API Error', ['lender_id' => $key + 1]);
                }
            });
        }

        Log::info('Completed Fetching Rates');
        Utils::settle($promises)->wait();

    }

    // helpers

    private function term($additionalValue) {
        preg_match('/\d+/', $additionalValue ?? '', $matches);
        return $matches[0] ?? null;
    }

    private function isLendingRate($loanPurpose, $repaymentType) {
        return in_array($loanPurpose, ['INVESTMENT', 'OWNER_OCCUPIED']) && in_array($repaymentType, ['PRINCIPAL_AND_INTEREST', 'INTEREST_ONLY']);
    }

    private function tierName ($measurement) {
        $tierName = null;
        $m = strtoupper($measurement);

        switch ($m) {
            case 'PERCENT':
                $tierName = 'LVR';
            break;
            case 'DOLLAR':
                $tierName = 'BALANCE';
            break;
            case 'MONTH':
                $tierName = 'TERM';
            break;
            default:
                $tierName = null;
            break;
        }

        return $tierName;
    }

    private function fixedNoTiers ($data) {
        try {
            FixedRate::insert([
                [
                    'lender_id' => $data['lender_id'],
                    'lender_rate_additional_info' => $data['lender_rate_additional_info'],
                    'productID' => $data['productID'],
                    'loan_rate' => $data['loan_rate'],
                    'comparison_rate' => $data['comparison_rate'],
                    'loan_term' => $data['loan_term'],
                    'loan_purpose' => $data['loan_purpose'],
                    'loan_type' => $data['loan_type'],
                    'repayment_type' => $data['repayment_type'],
                    'tier_name' => isset($data['tier_name']) ? $data['tier_name'] : null,
                    'tier_min' => isset($data['tier_min']) ? $data['tier_min'] : '0.00',
                    'tier_max' => isset($data['tier_max']) ? $data['tier_max'] : '0.00',
                    'tier_unitOfMeasure' => isset($data['tier_unitOfMeasure']) ? $data['tier_unitOfMeasure'] : null,
                    'tier_additional_info' => isset($data['tier_additional_info']) ? $data['tier_additional_info'] : null,
                    'product_name' => $data['product_name'],
                    'product_description' => $data['product_description'],
                    'with_package' => isset($data['with_package']) ? $data['with_package'] : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
        catch (\Exception $e) {
            Log::error('Error Inserting Fixed Rate No Tiers', ['lender' => $data['lender_id'], 'error' => $e->getMessage()]);
        }
    }

    private function fixedWithTiers ($data) {
        try {
            FixedRate::insert([
                [
                    'lender_id' => $data['lender_id'],
                    'lender_rate_additional_info' => $data['lender_rate_additional_info'],
                    'productID' => $data['productID'],
                    'loan_rate' => $data['loan_rate'],
                    'comparison_rate' => $data['comparison_rate'],
                    'loan_term' => $data['loan_term'],
                    'loan_purpose' => $data['loan_purpose'],
                    'loan_type' => $data['loan_type'],
                    'repayment_type' => $data['repayment_type'],
                    'tier_name' => $data['tier_name'],
                    'tier_min' => $data['tier_min'],
                    'tier_max' => $data['tier_max'],
                    'tier_unitOfMeasure' => $data['tier_unitOfMeasure'],
                    'tier_additional_info' => $data['tier_additional_info'],
                    'product_name' => $data['product_name'],
                    'product_description' => $data['product_description'],
                    'with_package' => isset($data['with_package']) ? $data['with_package'] : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
        catch (\Exception $e) {
            Log::error('Error Inserting Fixed Rate', ['lender' => $data['lender_id'], 'error' => $e->getMessage()]);
        }
    }

    private function variableNoTiers ($data) {
        try {
            VariableRate::insert([
                [
                    'lender_id' => $data['lender_id'],
                    'lender_rate_additional_info' => $data['lender_rate_additional_info'],
                    'productID' => $data['productID'],
                    'loan_rate' => $data['loan_rate'],
                    'comparison_rate' =>  $data['comparison_rate'],
                    'loan_purpose' => $data['loan_purpose'],
                    'loan_type' => $data['loan_type'],
                    'repayment_type' => $data['repayment_type'],
                    'tier_name' => isset($data['tier_name']) ? $data['tier_name'] : null,
                    'tier_min' => isset($data['tier_min']) ? $data['tier_min'] : '0.00',
                    'tier_max' => isset($data['tier_max']) ? $data['tier_max'] : '0.00',
                    'tier_unitOfMeasure' => isset($data['tier_unitOfMeasure']) ? $data['tier_unitOfMeasure'] : null,
                    'tier_additional_info' => isset($data['tier_additional_info']) ? $data['tier_additional_info'] : null,
                    'product_name' => $data['product_name'],
                    'product_description' => $data['product_description'],
                    'with_package' => isset($data['with_package']) ? $data['with_package'] : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
        catch (\Exception $e) {
            Log::error('Error Inserting Variable Rate', ['lender' => $data['lender_id'], 'error' => $e->getMessage()]);
        }
    }

    private function variableWithTiers ($data) {
        try {
            VariableRate::insert([
                [
                    'lender_id' => $data['lender_id'],
                    'lender_rate_additional_info' => $data['lender_rate_additional_info'],
                    'productID' => $data['productID'],
                    'loan_rate' => $data['loan_rate'],
                    'comparison_rate' =>  $data['comparison_rate'],
                    'loan_purpose' => $data['loan_purpose'],
                    'loan_type' => $data['loan_type'],
                    'repayment_type' => $data['repayment_type'],
                    'tier_name' => $data['tier_name'],
                    'tier_min' => $data['tier_min'],
                    'tier_max' => $data['tier_max'],
                    'tier_unitOfMeasure' => $data['tier_unitOfMeasure'],
                    'tier_additional_info' => $data['tier_additional_info'],
                    'product_name' => $data['product_name'],
                    'product_description' => $data['product_description'],
                    'with_package' => isset($data['with_package']) ? $data['with_package'] : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
        catch (\Exception $e) {
            Log::error('Error Inserting Variable Rate', ['lender' => $data['lender_id'], 'error' => $e->getMessage()]);
        }
    }

    private function bendigoLvrMinMax ($additionalInfo) {

        $min = null;
        $max = null;

        $info = trim($additionalInfo);
        if (preg_match('/LVR < (\d+\.\d+)/', $info, $match)) {
            $min = '0.00';
            $max = $match[1];
        } elseif (preg_match('/LVR (\d+\.\d+) - (\d+)%?/', $info, $match)) {
            $min = $match[1];
            $max = $match[2];
        } elseif (preg_match('/LVR > (\d+)/', $info, $match)) {
            $min = $match[1];
            $max = '100.00';
        }

        return ['min' => $min, 'max' => $max];
    }

    private function pnbankLvrMinMax ($productIdName) {
        $min = null;
        $max = null;

        if (preg_match('/LVR\s*(>|<)\s*(\d+)/', $productIdName, $matches)) {
            $operator = $matches[1];
            $value = floatval($matches[2]);

            if ($operator === '>') {
                $min = number_format($value, 2);
                $max = '100.00';
            } elseif ($operator === '<') {
                $min = '0.00';
                $max = number_format($value, 2);
            }
        }
        return ['min' => $min, 'max' => $max];
    }

    private function adelaideLvrMinMax ($additionalInfo) {
        $min = null;
        $max = null;

        if (preg_match('/LVR\s*>\s*(\d+(\.\d+)?)%?/', $additionalInfo, $matches)) {
            $value = floatval($matches[1]);
            $min = number_format($value, 2);
            $max = '100.00';
            // return number_format($value, 2) . " - 100.00";
        }
        elseif (preg_match('/LVR\s*<\s*(\d+(\.\d+)?)%?/', $additionalInfo, $matches)) {
            $value = floatval($matches[1]);
            $min = '0.00';
            $max = number_format($value, 2);
            // return "0.00 - " . number_format($value, 2);
        }
        elseif (preg_match('/LVR\s*(\d+(\.\d+)?)\s*-\s*(\d+(\.\d+)?)%?/', $additionalInfo, $matches)) {
            $min = number_format($matches[1], 2);
            $max = number_format($matches[3], 2);
            // return number_format($matches[1], 2) . " - " . number_format($matches[3], 2);
        }

        return ['min' => $min, 'max' => $max];
    }

    private function beyondBankAusLvrMinMax ($additionalInfo) {
        $min = null;
        $max = null;


        if (preg_match('/LVR\s*(>=|>)\s*(\d+(\.\d+)?)%?/', $additionalInfo, $matches)) {
            if (preg_match('/LVR\s*>\s*(\d+(\.\d+)?)%\s*-\s*<\s*(\d+(\.\d+)?)%?/', $additionalInfo, $matches)) {
                $min = number_format($matches[1], 2);
                $max = number_format($matches[3], 2);
                return ['min' => $min, 'max' => $max];
            }
            $value = floatval($matches[2]);
            $min = number_format($value, 2);
            $max = '100.00';
            // return number_format($value, 2) . " - 100.00";
        }
        elseif (preg_match('/LVR\s*(<=|<)\s*(\d+(\.\d+)?)%?/', $additionalInfo, $matches)) {
            $value = floatval($matches[2]);
            $min = '0.00';
            $max = number_format($value, 2);
            // return "0.00 - " . number_format($value, 2);
        }

        return ['min' => $min, 'max' => $max];
    }

    private function creditUnionSALvrMinMax ($additionalInfo) {
        $min = null;
        $max = null;

        if (preg_match('/≤\s*(\d+(\.\d+)?)%?/', $additionalInfo, $matches)) {
            $max = '0.00';
            $max = number_format(floatval($matches[1]), 2);
        }

        return ['min' => $min, 'max' => $max];
    }

    public function creditUnionSATerm ($additionalInfo) {
        $term = null;

        if (preg_match('/\b(\d+)\s*year\b/', $additionalInfo, $matches)) {
            $term = $matches[1];
        }

        return $term;
    }
}
