<?php

namespace App\Http\Controllers\RemoteGeneration;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRegistrateRequest;
use App\Services\RemoteGeneration\RgApplication;

class ApplicationController extends Controller
{
    public function registrateApplication(ApplicationRegistrateRequest $request, RgApplication $service)
    {
        if ($service->registrate($request)) {
            return response('Успешно', 201);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', '500');
    }
}
