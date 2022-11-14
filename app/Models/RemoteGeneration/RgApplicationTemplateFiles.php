<?php

namespace App\Models\RemoteGeneration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RgApplicationTemplateFiles extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['application_template_id', 'path'];
    protected $guarded = ['application_template_id'];

    public function applicationTemplate()
    {
        return $this->belongsTo(RgApplicationsTemplate::class, 'application_template_id', 'id');
    }
}
