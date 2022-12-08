<?php

namespace App\Services\RemoteGeneration;

use App\Enums\FileTypes;
use App\Enums\Statuses;
use App\Http\Resources\ApplicationCreateResource;
use App\Http\Resources\RemoteGeneration\RgApplicationResource;
use App\Http\Resources\RemoteGeneration\RgClientApplicationsResource;
use App\Http\Resources\RemoteGeneration\RgUrDnGenerationResource;
use App\Jobs\RemoteGeneration\RetrieveRemoteStatusJob;
use App\Models\RemoteGeneration\RgApplications;
use App\Models\RemoteGeneration\RgApplicationsTemplate;
use App\Services\CryptoHelper;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\InputBag;

class RgApplication
{
    public function index(InputBag $query)
    {
        $rg_applications = RgApplications::query()->with(['manager', 'template']);
        $currentPage = $query->get('page');

        if ($query->get('sort')) {
            $sortby = explode(';', $query->get('sort'));
            foreach ($sortby as $sortbyraw) {
                $sorts = explode(',', $sortbyraw);
                $rg_applications->orderBy($sorts[0], $sorts[1]);
            }
        }

        if ($query->get('status')) {
            $rg_applications->orWhere('status', $query->get('status'));
        }

        if ($query->get('search')) {
            $rg_applications->orWhere('rg_applications.id', 'like', '%' . $query->get('search') . '%');
            $rg_applications->orWhere('rg_applications.ac_id', 'like', '%' . $query->get('search') . '%');
            $rg_applications->orWhere('rg_managers.fio', 'like', '%' . $query->get('search') . '%');
            $rg_applications->orWhere('rg_applications.pin_code', 'like', '%' . $query->get('search') . '%');
            $rg_applications->orWhere('rg_applications.comment', 'like', '%' . $query->get('search') . '%');
            $rg_applications->orWhere('rg_applications.action_type', 'like', '%' . $query->get('search') . '%');
            $rg_applications->orWhere('rg_applications.store_number', 'like', '%' . $query->get('search') . '%');
            $rg_applications->orWhere('rg_applications.serial_number_certificate', 'like', '%' . $query->get('search') . '%');
            $rg_applications->orWhere('rg_applications.replace_serial_key', 'like', '%' . $query->get('search') . '%');
        }
        if ($query->get('deleted', 'false') === 'true') {
            $rg_applications->withTrashed();
        }
        if ($query->get('owned', false) === 'true') {
            $rg_applications->where('rg_applications.created_by', '=', auth()->id());
        }

        return RgApplicationResource::collection($rg_applications->paginate(6, ['*'], 'page', $currentPage));
    }

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
            RetrieveRemoteStatusJob::dispatch($requestId)->delay(now()->addSeconds(40));
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
        $model = RgApplications::whereAcId($requestId)->first();
        $response = $this->getRemoteStatus($model);

        if ($response->successful()) {
            $status = Statuses::from($response->json('0.statusId'));
            $model->status = $status->label;
            $model->save();
            return $status;
        }

        return $response->toException();
    }

    public function getRemoteStatus(RgApplications $model): \Illuminate\Http\Client\Response
    {
        $apiUrl = config('AC.API_URL');
        $method = config('AC.METHODS.STATUS_CHECK');

        return Http::post($apiUrl . $method, [
            'login' => $model->ac_login,
            'pass' => $model->ac_pass,
            'requests' => [$model->ac_id]
        ]);
    }

    public function destroy($id): ?bool
    {
        $application = RgApplications::withTrashed()->find($id);

        if ($application->trashed()) {
            return $application->restore();
        }
        return $application->delete();
    }

    public function indexApplicationsByCompany(\App\Models\RemoteGeneration\RgCompany $rgCompany, $query)
    {
        $rg_applications = $rgCompany->applications();
        $currentPage = $query->get('page');

        if ($query->get('sort')) {
            $sortby = explode(';', $query->get('sort'));
            foreach ($sortby as $sortbyraw) {
                $sorts = explode(',', $sortbyraw);
                $rg_applications->orderBy($sorts[0], $sorts[1]);
            }
        }

        if ($query->get('status')) {
            $rg_applications->orWhere('status', $query->get('status'));
        }

        if ($query->get('search')) {
            $rg_applications->orWhere('rg_applications.id', 'like', '%' . $query->get('search') . '%');
            $rg_applications->orWhere('rg_applications.ac_id', 'like', '%' . $query->get('search') . '%');
            $rg_applications->orWhere('rg_applications.comment', 'like', '%' . $query->get('search') . '%');
            $rg_applications->orWhere('rg_applications.serial_number_certificate', 'like', '%' . $query->get('search') . '%');
            $rg_applications->orWhere('rg_applications.replace_serial_key', 'like', '%' . $query->get('search') . '%');
        }
        if ($query->get('deleted', 'false') === 'true') {
            $rg_applications->withTrashed();
        }

        return RgClientApplicationsResource::collection($rg_applications->paginate(6, ['*'], 'page', $currentPage));
    }

    public function collectDn(RgApplications $rgApplication)
    {
        $template = $rgApplication->template;

        return new RgUrDnGenerationResource($template);
    }

    public function updateCertificateFields(RgApplications $application)
    {
        $certificateBinary = \Storage::get($application->files()->whereType(FileTypes::CERTIFICATE()->label)->first()->path);
        $cryptoService = new CryptoHelper();
        $result = $cryptoService->parseCertificateForDateAndSn($certificateBinary);

        $application->update([
            'certificate_produced_at' => $result[0],
            'certificate_finished_at' => $result[1],
            'serial_number_certificate' => $result[2],
        ]);
    }
}
