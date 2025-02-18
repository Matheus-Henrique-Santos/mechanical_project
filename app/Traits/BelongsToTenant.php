<?php

namespace App\Traits;

use App\Models\Tenant;
use App\Models\User;

trait  BelongsToTenant
{
    public static function boot()
    {
        parent::boot();

        if (auth()->check()) {
            static::addGlobalScope('tenant', function ($builder) {
                $builder->where('tenant_id', auth()->user()->tenant_id);
            });
        }

        static::creating(function($role) {
            if (!$role->tenant_id) {
                $role->tenant_id = auth()->user()->tenant_id;
            }
        });
    }

    public function scopeWithTenant($builder)
    {
        $builder->where('tenant_id', auth()->user()->tenant_id);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }

    public function hasScope($name)
    {
        return $this->tenant->scope === $name;
    }
}
