<?php

namespace App\Models\RemoteGeneration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property int $type 1 - физ.лицо, 2 - ИП, 3 - Юр лицо
 */
class RgApplicationsTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function manager(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RgManager::class, 'created_by', 'id');
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RgCompany::class, 'created_for', 'id');
    }

    public function files(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RgApplicationTemplateFiles::class, 'application_template_id', 'id');
    }

    public function applications(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->hasMany(RgApplications::class, RgApplications::class, 'id', 'template_id');
    }
}
