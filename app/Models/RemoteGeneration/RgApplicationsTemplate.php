<?php

namespace App\Models\RemoteGeneration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;


class RgApplicationsTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    public function manager(): HasOne
    {
        return $this->hasOne(RgManager::class, 'id', 'created_by');
    }

    public function company(): HasOne
    {
        return $this->hasOne(RgCompany::class, 'id', 'created_for');
    }

    public function files()
    {
        return $this->hasMany(RgApplicationTemplateFiles::class, 'application_template_id', 'id');
    }

    public function applications()
    {
        return $this->hasMany(RgApplications::class, 'template_id', 'id');
    }
}
