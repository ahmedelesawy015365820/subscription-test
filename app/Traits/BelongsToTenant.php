<?php


namespace App\Traits;


trait BelongsToTenant
{
    protected static function booted()
    {
        static::creating(function ($model) {
            if (app()->bound('current_tenant_id')) {
                $model->tenant_id = app('current_tenant_id');
            }
        });

        static::addGlobalScope('tenant', function ($query) {
            if (app()->bound('current_tenant_id')) {
                $query->where('tenant_id', app('current_tenant_id'));
            }
        });
    }
}
