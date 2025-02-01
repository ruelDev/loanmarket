<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLenders extends Model
{
    use HasFactory;

    protected $table = 'client_lender';

    public function client() {
        return $this->belongsTo(ClientRecord::class, 'client_id');
    }
}
