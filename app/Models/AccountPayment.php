<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPayment extends Model
{
    use HasFactory;

    protected $table = 'account_payments';
    protected $fillable = [
        'company_id',
        'description',
        'total',
        'added_by',
        'status_id',
        'action',
    ];
}
