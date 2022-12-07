<?php

namespace App\Jobs\RemoteGeneration;

use App\Enums\FileTypes;
use App\Enums\Statuses;
use App\Models\RemoteGeneration\RgApplications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SendRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected RgApplications $application;

    public function __construct($application)
    {
        $this->application = is_int($application) ? RgApplications::whereAcId($application)->first() : $application;
    }

    public function handle()
    {
        try {
            $file = Storage::get($this->application->files()->whereType(FileTypes::REQUEST()->label)->first()->path);
            if ($this->sendRequest($file)) {
                $this->application->update(['status' => Statuses::GENERATING_CERTIFICATE()->label]);
            }
        } catch (\Exception $exception) {
            $this->fail($exception);
        }
    }

    public function sendRequest($file): bool
    {
        $apiUrl = config('AC.API_URL');
        $method = config('AC.METHODS.FILE_ATTACH');

        return Http::post($apiUrl . $method, [
            'login' => $this->application->ac_login,
            'pass' => $this->application->ac_pass,
            'requestId' => $this->application->ac_id,
            'File_Name' => 'request.p10',
            'File' => base64_encode($file),
            'FileType' => FileTypes::REQUEST()->value
        ])->successful();
    }

    public function failed($exception)
    {
        Log::alert($exception->getMessage(), ['applicationId' => $this->application->id]);
    }
}
