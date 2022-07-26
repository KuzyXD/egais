<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ManagerLoginAuthenticate;

class ManagerController extends Controller
{
    public function authenticate(ManagerLoginAuthenticate $request)
    {
        if (Auth::guard('manager')->attempt($request->validated())) {
            $request->session()->regenerate();

            return response('Успешный вход');
        }

        return response('Ошибка ввода данных', 404);
    }
}
