<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{

    use HasFactory,SoftDeletes,BelongsToTenant;

    protected $fillable = [
        'tenant_id','name','type'
    ];

    public function journalLines()
    {
        return $this->hasMany(JournalEntryLine::class);
    }

    protected function casts(): array
    {
        return [
            'type' => \App\Enums\AccountType::class,
        ];
    }
}
