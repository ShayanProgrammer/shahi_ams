<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'import_duty_id',
        'customer_bill_id',
        'customer_payment_id',
        'cheque_no',
        'debit',
        'credit',
        'added_by',
        'status_id',
        'action',
    ];
}
