<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Enums\PaymentStatus;
use App\Enums\Currency;

class Payment extends Model
{

    protected $fillable = ['subscription_id','amount','currency','status'];

    protected $casts = [
        'status' => PaymentStatus::class,
        'currency' => Currency::class,
    ];

}
