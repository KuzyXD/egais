<?php

namespace App\Models\RemoteGeneration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class RgCompany extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    public function manager(): HasOne
    {
        return $this->hasOne(RgManager::class, 'id', 'manager_id');
    }

    public function applicationTemplates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RgApplicationsTemplate::class, 'created_for', 'id');
    }
}
