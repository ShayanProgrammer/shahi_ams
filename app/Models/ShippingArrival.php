<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingArrival extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'item_description',
        'no_of_container',
        'container_no',
        'bl_tracking',
        'port_name',
        'import_status_id',
        'arrival_date',
        'added_by',
        'status_id',
        'action',
    ];
}
