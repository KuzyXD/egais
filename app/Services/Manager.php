<?php

namespace App\Services;

use App\Models\Manager as ModelsManager;
use Illuminate\Support\Facades\Hash;

class Manager
{
    public function create($parameters): ModelsManager
    {
        $parameters['password'] = Hash::make($parameters['password']);

        return ModelsManager::create($parameters);
    }
}
