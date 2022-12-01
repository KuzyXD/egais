<?php

namespace App\Models\RemoteGeneration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RgApplications extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['ac_pass', 'ac_login'];

    public function manager(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(RgManager::class, 'id', 'created_by');
    }

    public function template(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(RgApplicationsTemplate::class, 'id', 'template_id');
    }

    public function files(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RgApplicationFiles::class, 'application_id', 'id');
    }
}
