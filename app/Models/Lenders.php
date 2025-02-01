<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lenders extends Model
{
    use HasFactory;

    protected $table = 'lenders';

    protected $fillable = [
        'name',
    ];

    public function lenderRates()
    {
        return $this->hasMany(LenderRates::class, 'lender_id');
    }
}
