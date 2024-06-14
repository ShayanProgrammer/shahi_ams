<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_bill_id',
        'debit',
        'bank_id',
        'paid_payment',
        'credit',
        'added_by',
        'status_id',
        'action',
    ];
}

