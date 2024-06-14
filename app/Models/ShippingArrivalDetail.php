<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingArrivalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_arrival_id',
        'container_number',
        'is_arrived',
        'status_id',
        'action',
    ];
}
