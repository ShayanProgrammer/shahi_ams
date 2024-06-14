<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearingAgentAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'clearing_agent_id',
        'bl_no',
        'bill_no',
        'no_of_container',
        'description',
        'date',
        'debit',
        'credit',
        'added_by',
        'status_id',
        'action',
    ];
}
