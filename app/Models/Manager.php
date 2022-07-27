<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Manager extends Authenticatable {
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = ['fio', 'email', 'password', 'tel'];
}
