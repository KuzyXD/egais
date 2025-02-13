<?php

namespace App\Http\Controllers\RemoteGeneration;

use App\Enums\Statuses;
use App\Enums\TranslatedStatuses;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRegistrateRequest;
use App\Http\Requests\ChangeStatusRequest;
use App\Jobs\RemoteGeneration\SendDocumentsJob;
use App\Jobs\RemoteGeneration\SendRequestJob;
use App\Models\RemoteGeneration\RgApplications;
use App\Models\RemoteGeneration\RgCompany;
use App\Services\RemoteGeneration\RgApplication;
use App\Services\RemoteGeneration\RgGetSignedRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        $paginate = $service->indexApplicationsByCompany($company, $request->query);
        if ($paginate) {
            return $paginate->response();
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

    public function getSignedRoute(Request $request, RgApplications $rgApplication, RgGetSignedRoute $service)
    {
        return redirect($service->getSignedRoute($rgApplication));
    }

    public function getStatus(Request $request, RgApplications $rgApplication)
    {
        return response($rgApplication->status, 200);
    }

    public function getDn(Request $request, RgApplications $rgApplication, RgApplication $service)
    {
        $dn = $service->collectDn($rgApplication);
        if ($dn) {
            return $dn->response();
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function sendDocs(Request $request, RgApplications $rgApplication)
    {
        SendDocumentsJob::dispatch($rgApplication);

        return response('', 200);
    }

    public function sendRequest(Request $request, RgApplications $rgApplication)
    {
        SendRequestJob::dispatch($rgApplication);

        return response('', 200);
    }

    public function getStatuses(Request $request)
    {
        $enStatuses = collect(Statuses::toLabels());
        $ruStatuses = collect(TranslatedStatuses::toValues());

        return response($enStatuses->combine($ruStatuses), 200);
    }

    public function changeStatus(ChangeStatusRequest $request, RgApplications $rgApplication)
    {
        if($rgApplication->update(['status' => $request->get('status')])) {
            return response('Успешно', 200);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }
}
