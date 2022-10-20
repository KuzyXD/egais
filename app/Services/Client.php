<?php

namespace App\Services;

use App\Models\Client as ModelsClient;
use Illuminate\Support\Facades\Hash;

class Client
{
    public function create($parameters): ModelsClient
    {
        $parameters['password'] = Hash::make($parameters['password']);

        return ModelsClient::create($parameters);
    }
}
