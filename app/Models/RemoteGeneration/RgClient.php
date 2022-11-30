<?php

namespace App\Models\RemoteGeneration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class RgClient extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $guarded = [];

    public function companies()
    {
        return $this->hasMany(RgCompany::class, 'group', 'group');
    }
}
