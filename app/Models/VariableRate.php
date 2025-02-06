<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariableRate extends Model
{
    use HasFactory;

    protected $table = 'lender_rates_variable';

    protected $fillable = [
        'lender_id',
        'loan_rate',
        'comparison_rate',
        'loan_type',
        'repayment_type',
        'loan_purpose',
        'tier_name',
        'tier_min',
        'tier_max',
        'tier_unitOfMeasure',
    ];
}
