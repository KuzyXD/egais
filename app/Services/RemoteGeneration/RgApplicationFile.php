<?php

namespace App\Services\RemoteGeneration;

use App\Models\RemoteGeneration\RgApplicationFiles;
use App\Models\RemoteGeneration\RgApplications;
use Illuminate\Http\Request;

class RgApplicationFile
{
    public function store(Request $parameters, RgApplications $rgApplication): bool
    {
        $files = $rgApplication->files();
        $rgApplicationId = $rgApplication->id;
        $oldFile = $files->whereType($parameters['type'])->first();

        if ($oldFile) {
            $this->destroy($oldFile->id);
        }

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

    public function destroy(RgApplicationFiles $files): ?bool
    {
        if ($files->trashed()) {
            return $files->restore();
        }
        return $files->delete();
    }
}
