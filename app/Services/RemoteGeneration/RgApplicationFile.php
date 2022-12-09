<?php

namespace App\Services\RemoteGeneration;

use App\Models\RemoteGeneration\RgApplicationFiles;
use App\Models\RemoteGeneration\RgApplications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RgApplicationFile
{
    public function getTemplateFiles(RgApplications $application): bool
    {
        $collection = $application->templateFiles()->get();
        $applicationFiles = $application->files();

        foreach ($collection as $item) {
            $this->deleteOldFile($application->files()->get(), $item['type']);
            $applicationFiles->create($item->only(['type', 'name', 'path']));
        }

        return true;
    }

    public function deleteOldFile($files, $type): void
    {
        $oldFile = $files->where('type', $type)->first();

        if ($oldFile) {
            $this->destroy($oldFile);
        }
    }

    public function destroy(RgApplicationFiles $files): ?bool
    {
        if ($files->trashed()) {
            return $files->restore();
        }
        return $files->delete();
    }

    public function store(Request $parameters, RgApplications $rgApplication): bool
    {
        $files = $rgApplication->files();
        $rgApplicationId = $rgApplication->id;

        $this->deleteOldFile($files, $parameters['type']);

        $fileName = $parameters->file('file')->getClientOriginalName();
        $path = $parameters->file('file')->store("/files/$rgApplicationId");

        if ($path) {
            $files->create([
                'name' => $fileName,
                'path' => $path,
                'type' => $parameters->get('type')
            ]);

            return true;
        }
        return false;
    }

    public function storeRequestInBase64(Request $parameters, RgApplications $rgApplication): bool
    {
        $files = $rgApplication->files();
        $rgApplicationId = $rgApplication->id;

        $this->deleteOldFile($files, $parameters['type']);

        $fileName = "request.p10";
        $path = "files/$rgApplicationId/$fileName";
        $stored = Storage::put($path, $parameters['file']);

        if ($stored) {
            $files->create([
                'name' => $fileName,
                'path' => $path,
                'type' => $parameters->get('type')
            ]);
            return true;
        }
        return false;
    }
}
