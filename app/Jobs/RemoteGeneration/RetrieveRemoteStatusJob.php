<?php

namespace App\Jobs\RemoteGeneration;

use App\Enums\Statuses;
use App\Models\RemoteGeneration\RgApplications;
use App\Services\RemoteGeneration\RgApplication;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RetrieveRemoteStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected RgApplications $application;

    public function __construct($application)
    {
        $this->application = is_int($application) ? RgApplications::whereAcId($application)->first() : $application;
    }

    public function handle(RgApplication $rgApplicationsService)
    {
        $status = $rgApplicationsService->retrieveRemoteStatus($this->application->ac_id);

        if ($status instanceof Exception) {
            $this->fail($status);
        }

        if($status->equals(Statuses::SYSTEM_PROCESSING()->label)) {
            RetrieveRemoteStatusJob::dispatch($this->application);
        }
    }

    public function failed(RequestException $exception)
    {
        Log::alert($exception->getMessage(), ['applicationId' => $this->application->id, 'exception' => $exception->response]);
    }
}
