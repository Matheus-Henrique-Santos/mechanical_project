<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Domain;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    use HasFactory;
    use HasDatabase;
    use HasDomains;

    protected $fillable = [
        'id',
        'name',
        'email',
        'user_principal',
        'user_principal',
        'subdomain',
        'name',
        'address',
        'type',
        'document',
        'phone'
    ];
}
