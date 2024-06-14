<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacketListDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'packet_list_id',
        'size',
        'status_id',
        'action',
    ];

}
