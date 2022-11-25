<?php

namespace App\Http\Controllers\RemoteGeneration;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Http\Resources\RemoteGeneration\RgClientResource;
use App\Models\RemoteGeneration\RgClient;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request, \App\Services\RemoteGeneration\RgClient $service)
    {
        $paginate = $service->index($request->query);
        if ($paginate) {
            return $paginate->response();
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function store(ClientStoreRequest $request, \App\Services\RemoteGeneration\RgClient $service)
    {
        if ($service->create($request->validated())) {
            return response('Успешно', 201);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function show(RgClient $rgClient)
    {
        return new RgClientResource($rgClient);
    }

    public function update(ClientUpdateRequest $request, RgClient $rgClient, \App\Services\RemoteGeneration\RgClient $service)
    {
        if ($service->update($request->validated(), $rgClient)) {
            return response('Успешно', 200);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function destroy(RgClient $rgClient, \App\Services\RemoteGeneration\RgClient $service)
    {
        if ($service->destroy($rgClient)) {
            return response('Успешно', 200);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }
}
