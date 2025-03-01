<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedRate extends Model
{
    use HasFactory;

    protected $table = 'lender_rates_fixed';

    protected $fillable = [
        'lender_id',
        'lender_rate_additional_info',
        'productID',
        'loan_rate',
        'loan_term',
        'comparison_rate',
        'loan_purpose',
        'loan_type',
        'repayment_type',
        'tier_name',
        'tier_min',
        'tier_max',
        'tier_unitOfMeasure',
        'product_name',
        'product_additional_info',
        'product_description'
    ];

    public function lender()
    {
        return $this->belongsTo(Lenders::class, 'lender_id');
    }
}
