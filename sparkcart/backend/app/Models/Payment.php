<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'merchant_request_id',
        'checkout_request_id',
        'result_code',
        'result_desc',
        'status',
        'phone_number',
        'amount',
        'account_reference',
        'transaction_desc',
        'callback_payload',
        'received_at',
    ];

    protected $casts = [
        'callback_payload' => 'array',
        'received_at' => 'datetime',
    ];
}
