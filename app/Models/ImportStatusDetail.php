<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportStatusDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'import_status_id',
        'size',
        'rate',
        'quantity',
        'length',
        'status_id',
        'action',
    ];
}
