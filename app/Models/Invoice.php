<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{

    use HasFactory,SoftDeletes,BelongsToTenant;

    protected $fillable = [
        'tenant_id','customer_id','subscription_id',
        'amount','status','due_date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    protected function casts(): array
    {
        return [
            'status' => \App\Enums\InvoiceStatus::class,
        ];
    }
}
