<?php

namespace App\Http\Controllers\RemoteGeneration;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientGroupUpdateRequest;
use App\Models\RemoteGeneration\RgClient;
use App\Services\RemoteGeneration\RgClientGroup;
use Illuminate\Http\Request;

class ClientGroupController extends Controller
{
    public function index(RgClientGroup $service)
    {
        $data = $service->index();
        if ($data) {
            return response($data, 200);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function show(RgClient $rgClient, RgClientGroup $service)
    {
        $data = $service->show($rgClient);
        if ($data) {
            return response($data, 200);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function update(ClientGroupUpdateRequest $request, RgClient $rgClient, RgClientGroup $service)
    {
        if ($service->update($rgClient, $request->validated()['group'])) {
            return response('Успешно', 200);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }
}
