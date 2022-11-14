<?php

namespace App\Services\RemoteGeneration;

use App\Models\RemoteGeneration\RgApplicationsTemplate;
use App\Models\RemoteGeneration\RgApplicationTemplateFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\InputBag;

class RgApplicationTemplateFile
{

    public function store(Request $parameters, $templateId): bool
    {
        $fileName = $parameters->file('file')->getClientOriginalName();
        $path = $parameters->file('file')->store("/templateFiles/$templateId");

        if ($path) {
            RgApplicationsTemplate::find($templateId)->files()->create([
                'name' => $fileName,
                'path' => $path,
                'type' => $parameters->get('type')
            ]);

            return true;
        }
        return false;
    }

    public function destroy($id): ?bool
    {
        $templateModel = RgApplicationTemplateFiles::withTrashed()->find($id);

        if ($templateModel->trashed()) {
            return $templateModel->restore();
        }
        return $templateModel->delete();
    }
}
