<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manager extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['fio', 'email', 'password', 'tel'];
}
