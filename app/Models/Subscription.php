<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\SubscriptionStatus;

class Subscription extends Model
{

    protected $fillable = ['user_id','plan_id','status','ends_at','grace_period_ends_at'];

    protected $casts = [
        'status' => SubscriptionStatus::class,
        'ends_at' => 'timestamp',
        'grace_period_ends_at' => 'timestamp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}
