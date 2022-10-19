<?php

namespace App\Http\Controllers\RemoteGeneration\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagerLoginAuthenticate;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function authenticate(ManagerLoginAuthenticate $request)
    {
        if (Auth::guard('rg-manager')->attempt($request->validated())) {
            $request->session()->regenerate();

            return response('Успешный вход');
        }

        return response('Ошибка ввода данных', 404);
    }
}
