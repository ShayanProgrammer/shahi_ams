<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'payment_type_id',
        'amount',
        'cheque_no',
        'bank_id',
        'added_by',
        'status_id',
        'action',
    ];
}
