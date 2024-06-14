<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBillDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_bill_id',
        'warehouse_id',
        'stocklist_id',
        'packetlist_id',
        'size',
        'rate',
        'quantity',
        'company'
    ];
}
