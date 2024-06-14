<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'import_status_id',
        'container_number',
        'port_name',
        'date',
        'file',
        'added_by',
        'status_id',
        'action',
    ];
}
