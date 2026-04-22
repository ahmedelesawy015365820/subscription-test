<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{

    use HasFactory,SoftDeletes,BelongsToTenant;

    protected $fillable = [
        'tenant_id','customer_id','plan_id',
        'start_date','end_date','status'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    protected function casts(): array
    {
        return [
            'status' => \App\Enums\SubscriptionStatus::class,
        ];
    }
}
