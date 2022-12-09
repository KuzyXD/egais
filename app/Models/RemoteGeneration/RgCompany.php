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

    public function manager(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RgManager::class, 'manager_id', 'id');
    }

    public function applicationTemplates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RgApplicationsTemplate::class, 'created_for', 'id');
    }

    public function applications(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(RgApplications::class, RgApplicationsTemplate::class, 'created_for', 'template_id');
    }
}
