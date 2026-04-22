<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalEntry extends Model
{

    use HasFactory,SoftDeletes,BelongsToTenant;

    protected $fillable = [
        'tenant_id','description','date'
    ];

    public function lines()
    {
        return $this->hasMany(JournalEntryLine::class);
    }

}
