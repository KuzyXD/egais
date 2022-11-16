<?php

namespace App\Services\RemoteGeneration;

use App\Models\RemoteGeneration\RgApplicationsTemplate;
use App\Models\RemoteGeneration\RgApplicationTemplateFiles;
use Illuminate\Http\Request;

class RgApplicationTemplateFile
{

    public function store(Request $parameters, $templateId): bool
    {
        $templateFiles = RgApplicationsTemplate::find($templateId)->files();
        $oldFile = $templateFiles->whereType($parameters['type'])->first();

        if ($oldFile) {
            $this->destroy($oldFile->id);
        }

        $fileName = $parameters->file('file')->getClientOriginalName();
        $path = $parameters->file('file')->store("/templateFiles/$templateId");

        if ($path) {
            $templateFiles->create([
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
