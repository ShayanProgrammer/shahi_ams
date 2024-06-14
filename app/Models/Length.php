<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Length extends Model
{
    use HasFactory;

    protected $fillable = [
        'packet_list_detail_id',
        'length',
        'quantity',
        'added_by',
        'status_id',
        'action',
    ];

}
