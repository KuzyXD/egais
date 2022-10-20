<?php

namespace App\Services\RemoteGeneration;

use App\Models\RemoteGeneration\RgManager as ModelsManager;
use Illuminate\Support\Facades\Hash;

class RgManager
{
    public function create($parameters): ModelsManager
    {
        $parameters['password'] = Hash::make($parameters['password']);

        return ModelsManager::create($parameters);
    }
}
