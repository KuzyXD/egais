<?php

namespace App\Models\RemoteGeneration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class RgManager extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = ['fio', 'email', 'password', 'tel'];

    public function companies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RgCompany::class, 'manager_id', 'id');
    }
}
