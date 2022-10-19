<?php

namespace App\Http\Controllers\RemoteGeneration\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientLoginAuthenticate;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function authenticate(ClientLoginAuthenticate $request)
    {
        if (Auth::guard('rg-client')->attempt($request->validated())) {
            $request->session()->regenerate();

            return response('Успешный вход');
        }

        return response('Ошибка ввода данных', 404);
    }
}
