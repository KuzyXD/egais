<?php

namespace App\Services\RemoteGeneration;

use App\Models\RemoteGeneration\RgApplications;
use Illuminate\Support\Facades\URL;

class RgGetSignedRoute
{
    public function getSignedRoute(RgApplications $rgApplication)
    {
        return URL::temporarySignedRoute('client.action', now()->addMinutes(30), ['id' => $rgApplication->id]);
    }
}
