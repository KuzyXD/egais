<?php

namespace App\Http\Controllers\RemoteGeneration;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationFileRequest;
use App\Http\Requests\ApplicationRequestFileRequest;
use App\Models\RemoteGeneration\RgApplicationFiles;
use App\Models\RemoteGeneration\RgApplications;
use App\Models\RemoteGeneration\RgApplicationTemplateFiles;
use App\Services\RemoteGeneration\RgApplication;
use App\Services\RemoteGeneration\RgApplicationFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationFilesController extends Controller
{
    public function index(RgApplications $application)
    {
        $data = $application->files;
        if ($data) {
            return response($data, 200);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function show(RgApplications $application, RgApplicationFiles $rgApplicationFiles)
    {
        return Storage::download($rgApplicationFiles->path, $rgApplicationFiles->name);
    }

    public function destroy(RgApplications $application, RgApplicationFiles $rgApplicationFiles, RgApplicationFile $service)
    {
        if ($service->destroy($rgApplicationFiles)) {
            return response('Успешно', 201);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function getTemplateFiles(RgApplications $application, RgApplicationFile $service)
    {
        if ($service->getTemplateFiles($application)) {
            return response('Успешно', 201);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function recieveRequestFileInBase64(ApplicationRequestFileRequest $request, RgApplications $rgApplication, RgApplicationFile $fileService, RgApplication $applicationService)
    {
        if ($fileService->storeRequestInBase64($request, $rgApplication)) {
            //todo отправить документы в АЦ
            return response('Успешно', 201);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function store(ApplicationFileRequest $request, RgApplications $application, RgApplicationFile $service)
    {
        if ($service->store($request, $application)) {
            return response('Успешно', 201);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }
}
