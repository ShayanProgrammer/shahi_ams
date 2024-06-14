<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'date',
        'payment_type_id',
        'cheque_no',
        'bank_id',
        'total',
        'added_by',
        'status_id',
        'action',
    ];
}
