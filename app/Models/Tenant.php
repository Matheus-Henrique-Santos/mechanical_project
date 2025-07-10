<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Domain;

class Tenant extends BaseTenant
{
    use HasDomains;

    protected $fillable = [
        'main_user_id',
        'name',
        'documents',
        'zip_code',
        'address',
        'city',
        'neighborhood',
        'number',
        'uf',
        'data',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'main_user_id',
            'name',
            'documents',
            'zip_code',
            'address',
            'city',
            'neighborhood',
            'number',
            'uf',
        ];
    }

    public function domain(): HasOne
    {
        return $this->hasOne(Domain::class, 'tenant_id', 'id');
    }
}
