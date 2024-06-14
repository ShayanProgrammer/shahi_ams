<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportDuties extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'check',
        'payorder',
        'performa',
        'amount',
        'no_of_container',
        'date',
        'added_by',
        'status_id',
        'action',
    ];
}
