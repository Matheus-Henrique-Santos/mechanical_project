<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Domain;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Tenant extends Model implements Authenticatable
{
    use AuthenticatableTrait;
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
