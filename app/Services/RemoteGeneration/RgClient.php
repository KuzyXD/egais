<?php

namespace App\Services\RemoteGeneration;

use App\Models\RemoteGeneration\RgClient as ModelsClient;
use Illuminate\Support\Facades\Hash;

class RgClient
{
    public function create($parameters): ModelsClient
    {
        $parameters['password'] = Hash::make($parameters['password']);

        return ModelsClient::create($parameters);
    }
}
