<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacketList extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'stock_list_id',
        'description',
        'added_by',
        'status_id',
        'action',
    ];

}
