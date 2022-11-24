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

    public function manager()
    {
        return $this->hasOne(RgManager::class, 'id', 'created_by');
    }

    public function template()
    {
        return $this->hasOne(RgApplicationsTemplate::class, 'id', 'template_id');
    }
}
