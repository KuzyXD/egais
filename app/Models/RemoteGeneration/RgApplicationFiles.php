<?php

namespace App\Models\RemoteGeneration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class RgApplicationFiles extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function application(): BelongsTo
    {
        return $this->belongsTo(RgApplications::class, 'application_id', 'id');
    }
}
