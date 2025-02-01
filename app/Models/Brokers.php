<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brokers extends Model
{
    use HasFactory;

    protected $table = 'brokers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'rso'
    ];
}
