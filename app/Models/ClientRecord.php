<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRecord extends Model
{
    use HasFactory;

    protected $table = 'client_record';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'broker_id',
    ];

    public function broker() {
        return $this->belongsTo(Brokers::class, 'broker_id');
    }
}
