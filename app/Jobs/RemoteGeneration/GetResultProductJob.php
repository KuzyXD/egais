<?php

namespace App\Jobs\RemoteGeneration;

use App\Enums\Statuses;
use App\Http\Resources\FileFromAC;
use App\Models\RemoteGeneration\RgApplicationFiles;
use App\Models\RemoteGeneration\RgApplications;
use App\Services\RemoteGeneration\RgApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GetResultProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected RgApplications $application;

    public function __construct($application)
    {
        $this->application = is_int($application) ? RgApplications::whereAcId($application)->first() : $application;
    }


    public function handle(RgApplication $service)
    {
        try {
            $incomingFiles = $this->getResult();

            if ($incomingFiles) {
                $collectionOfFiles = FileFromAC::collection($incomingFiles);

                foreach ($collectionOfFiles as $file) {
                    if (!$this->saveFiles($file->toArray(''))) {
                        throw new \Exception('Не удалось сохранить файл у заявки ' . $this->application->id);
                    }
                }
                $this->application->update(['status' => Statuses::READY_TO_INSTALL()->label]);
                $service->updateCertificateFields($this->application);
                return true;
            }
            $this->fail('Файлы не были обработаны');
        } catch (\Exception $exception) {
            $this->fail($exception);
        }
    }

    public function getResult()
    {
        $apiUrl = config('AC.API_URL');
        $method = config('AC.METHODS.RESULT');

        return Http::post($apiUrl . $method, [
            'login' => $this->application->ac_login,
            'pass' => $this->application->ac_pass,
            'requestId' => $this->application->ac_id,
        ])->json();
    }

    public function saveFiles($parameters): bool
    {
        $files = $this->application->files();
        $rgApplicationId = $this->application->id;

        $this->deleteOldFile($files, $parameters['type']);

        $fileName = $parameters['name'];
        $path = "/files/$rgApplicationId/$fileName";
        $stored = Storage::put($path, $parameters['file']);

        if ($stored) {
            $files->create([
                'name' => $fileName,
                'path' => $path,
                'type' => $parameters['type']
            ]);
            return true;
        }
        return false;
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

    public function failed($exception)
    {
        Log::alert($exception->getMessage(), ['applicationId' => $this->application->id]);
    }
}
