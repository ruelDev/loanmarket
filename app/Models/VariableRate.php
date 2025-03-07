<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariableRate extends Model
{
    use HasFactory;

    protected $table = 'lender_rates_variable';

    protected $fillable = [
        'unique_id',
        'lender_id',
        'lender_rate_additional_info',
        'productID',
        'loan_rate',
        'comparison_rate',
        'loan_type',
        'repayment_type',
        'loan_purpose',
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
