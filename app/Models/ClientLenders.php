<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLenders extends Model
{
    use HasFactory;

    protected $table = 'client_lender';

    protected $fillable = [
        'client_id',
        'property_address',
        'property_value',
        'lender',
        'loan_type',
        'loan_rate',
        'loan_term',
        'loan_monthly',
        'savings',
    ];

    public function client() {
        return $this->belongsTo(ClientRecord::class, 'client_id');
    }
}
