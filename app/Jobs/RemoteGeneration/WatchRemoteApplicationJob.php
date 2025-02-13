<?php

namespace App\Jobs\RemoteGeneration;

use App\Enums\Statuses;
use App\Models\RemoteGeneration\RgApplications;
use App\Services\RemoteGeneration\RgApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class WatchRemoteApplicationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected RgApplications $application;

    public function __construct($application)
    {
        $this->application = is_int($application) ? RgApplications::whereAcId($application)->first() : $application;
    }

    public function handle(RgApplication $rgApplicationsService)
    {
        try {
            return $this->fetchRemoteStatus($rgApplicationsService);
        } catch (\Exception $exception) {
            $this->fail($exception);
        }
    }

    public function fetchRemoteStatus(RgApplication $rgApplicationsService): bool
    {
        $status = $rgApplicationsService->getRemoteStatus($this->application)->json('0.statusId');
        $convertedStatus = Statuses::from($status);

        if ($convertedStatus->equals(Statuses::GENERATING_CERTIFICATE()) || $convertedStatus->equals(Statuses::IN_MODERATION())) {
            return true;
        }

        if ($convertedStatus->equals(Statuses::CERTIFICATE_READY())) {
            GetResultProductJob::dispatch($this->application)->delay(now()->addSeconds(5));
            return $this->application->update(['status' => $convertedStatus->label]);
        } else if ($convertedStatus->equals(Statuses::SENDING_DOCUMENTS()) || $convertedStatus->equals(Statuses::DECLINED())) {
            return $this->application->update(['status' => Statuses::DECLINED()->label]);
        } else {
            return $this->application->update(['status' => Statuses::UNKNOWN()->label]);
        }
    }

    public function failed(RequestException $exception)
    {
        Log::alert($exception->getMessage(), ['applicationId' => $this->application->id, 'exception' => $exception->response]);
    }
}
