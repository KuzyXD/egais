<?php

namespace App\Services\RemoteGeneration;

use App\Enums\Statuses;
use App\Http\Resources\ApplicationCreateResource;
use App\Jobs\RemoteGeneration\RetrieveRemoteStatusJob;
use App\Models\RemoteGeneration\RgApplications;
use App\Models\RemoteGeneration\RgApplicationsTemplate;
use Illuminate\Support\Facades\Http;

class RgApplication
{
    public function registrate($request): bool
    {
        $apiUrl = config('AC.API_URL');
        $method = config('AC.METHODS.REGISTRATE');

        $data = (new ApplicationCreateResource(RgApplicationsTemplate::findOrFail($request['templateId'])))->jsonSerialize();
        $response = Http::post($apiUrl . $method, [
            'login' => $request['login'],
            'pass' => $request['pass'],
            'info' => $data
        ]);

        $requestId = $response->json('requestId');
        $result = $this->saveApplication($request, $requestId);

        if ($result) {
            RetrieveRemoteStatusJob::dispatch($requestId)->delay(now()->addSeconds(20));
        }

        return $result;
    }

    public function saveApplication($request, $requestId): bool
    {
        $newApplication = new RgApplications([
            'template_id' => $request['templateId'],
            'ac_id' => $requestId,
            'created_by' => $request->user()->id,
            'status' => Statuses::CREATED()->label,
            'ac_login' => $request['login'],
            'ac_pass' => $request['pass'],
        ]);
        return $newApplication->saveOrFail();
    }

    public function retrieveRemoteStatus($requestId)
    {
        $apiUrl = config('AC.API_URL');
        $method = config('AC.METHODS.STATUS_CHECK');
        $model = RgApplications::whereAcId($requestId)->first();

        $response = Http::post($apiUrl . $method, [
            'login' => $model->ac_login,
            'pass' => $model->ac_pass,
            'requests' => [$requestId]
        ]);

        if ($response->successful()) {
            $model->status = Statuses::from($response->json('0.statusId'))->label;
            return $model->save();
        }

        return $response->toException();
    }
}
