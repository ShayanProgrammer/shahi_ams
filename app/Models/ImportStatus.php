<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportStatus extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'performa',
        'rate',
        'size',
        'quantity',
        'length',
        'date',
        'description',
        'added_by',
        'status_id',
        'action',
    ];
}
