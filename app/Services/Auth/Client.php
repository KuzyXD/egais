<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Hash;
use App\Models\Client as ModelsClient;

class Client
{
    public function create($parameters)
    {
        $parameters['password'] = Hash::make($parameters['password']);

        return ModelsClient::create($parameters);
    }
}
