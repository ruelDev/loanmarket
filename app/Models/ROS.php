<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ROS extends Model
{
    use HasFactory;

    protected $table = 'real_estate_offices';

    protected $fillable = [
        'name',
        'url',
        'email',
        'tagline',
        'call_to',
        'featured',
        'logo',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function client_record() {
        return $this->hasMany(ClientRecord::class, 'property_management');
    }
}
