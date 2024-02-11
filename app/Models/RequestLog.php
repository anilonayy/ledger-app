<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'path',
        'action',
        'method',
        'request_body',
        'status_code',
        'ip_address',
        'user_agent',
        'user_id',
        'duration',
        'created_at'
    ];
}
