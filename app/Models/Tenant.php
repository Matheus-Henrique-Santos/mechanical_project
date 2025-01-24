<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $table = 'tenancies';
    protected $fillable = [
        'name',
        'email',
        'address',
        'type',
        'document',
        'phone',
        'subdomain',
        'logo',
    ];
}

