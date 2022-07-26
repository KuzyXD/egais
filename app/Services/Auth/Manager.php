<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Hash;
use App\Models\Manager as ModelsManager;

class Manager
{
    public function create($parameters)
    {
        $parameters['password'] = Hash::make($parameters['password']);

        return ModelsManager::create($parameters);
    }
}
