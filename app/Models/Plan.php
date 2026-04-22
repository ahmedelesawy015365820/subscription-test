<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BillingCycle;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{

    use HasFactory,SoftDeletes,BelongsToTenant;

    protected $fillable = [
        'tenant_id','name','price','billing_cycle'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    protected function casts(): array
    {
        return [
            'billing_cycle' => \App\Enums\BillingCycle::class,
        ];
    }
}
