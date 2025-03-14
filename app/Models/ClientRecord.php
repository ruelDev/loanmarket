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
        'property_management',
        'date_inquiry',
    ];

    public function broker() {
        return $this->belongsTo(Brokers::class, 'broker_id');
    }

    public function property_management() {
        return $this->belongsTo(ROS::class, 'property_management');
    }
}
