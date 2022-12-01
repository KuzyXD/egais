<?php

namespace App\Http\Controllers\RemoteGeneration;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationFileRequest;
use App\Models\RemoteGeneration\RgApplicationTemplateFiles;
use App\Services\RemoteGeneration\RgApplicationTemplateFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationTemplateFilesController extends Controller
{
    public function index(Request $request, $templateId, RgApplicationTemplateFiles $model)
    {
        $data = $model->whereApplicationTemplateId($templateId)->get();
        if ($data) {
            return response($data, 200);
        }

        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function store(ApplicationFileRequest $request, $templateId, RgApplicationTemplateFile $service)
    {
        if ($service->store($request, $templateId)) {
            return response('Успешно', 201);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }

    public function show($fileId)
    {
        $model = RgApplicationTemplateFiles::find($fileId);

        return Storage::download($model->path, $model->name);
    }

    public function destroy(Request $request, $fileId, RgApplicationTemplateFile $service)
    {
        if ($service->destroy($fileId)) {
            return response('Успешно', 200);
        }
        return response('Произошла ошибка. Свяжитесь с программистом.', 500);
    }
}
