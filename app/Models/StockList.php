<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockList extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'company_id',
        'container_number',
        'date',
        'no_of_packets',
        'added_by',
        'status_id',
        'action',
    ];
}
