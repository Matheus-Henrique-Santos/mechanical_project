<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
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
        'main_user_id',
        'subdomain',
        'name',
        'cellphone',
        'cnpj',
        'logo_path',
        'zip_code',
        'street',
        'neighborhood',
        'city',
        'uf',
        'number',
        'complement',
    ];
}
