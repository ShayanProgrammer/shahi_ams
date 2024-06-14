<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'name',
        'company_id',
        'import_status_id',
        'account_payment_id',
        'description',
        'value',
        'total',
        'payable',
        'payment',
        'receivable',
        'added_by',
        'status_id',
        'action',
    ];
}
