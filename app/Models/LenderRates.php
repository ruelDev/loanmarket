<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LenderRates extends Model
{
    use HasFactory;

    protected $table = 'lender_rates';

    public function lender()
    {
        return $this->belongsTo(Lenders::class, 'lender_id');
    }

}
