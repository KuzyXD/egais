<?php

namespace App\Http\Controllers\RemoteGeneration;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRegistrateRequest;
use App\Models\RemoteGeneration\RgCompany;
use App\Services\RemoteGeneration\RgApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function registrateApplication(ApplicationRegistrateRequest $request, RgApplication $service)
    {
        if ($service->registrate($request)) {
            return response('Успешно', 201);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function destroy(Request $request, $id, RgApplication $service)
    {
        if ($service->destroy($id)) {
            return response('Успешно', 200);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function indexApplicationsByCompany(Request $request, RgCompany $company, RgApplication $service)
    {
        $result = $service->indexApplicationsByCompany($company);
        if ($result) {
            return response($result, 200);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function index(Request $request, RgApplication $service)
    {
        $paginate = $service->index($request->query);
        if ($paginate) {
            return $paginate->response();
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }
}
