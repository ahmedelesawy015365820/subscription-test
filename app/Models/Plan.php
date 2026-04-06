<?php

namespace App\Models;

use App\Observers\Administrator\PlanObserver;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BillingCycle;
use App\Enums\Currency;

class Plan extends Model
{

    protected $fillable = ['name','days','billing_cycle','currency','price', 'is_default'];

    protected $casts = [
        'billing_cycle' => BillingCycle::class,
        'currency' => Currency::class,
    ];

    protected static function booted()
    {
        static::observe(PlanObserver::class);
    }

}
