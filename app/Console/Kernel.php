<?php

namespace App\Console;

use App\Enums\Statuses;
use App\Jobs\RemoteGeneration\WatchRemoteApplicationJob;
use App\Models\RemoteGeneration\RgApplications;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $applications = RgApplications::whereStatus(Statuses::GENERATING_CERTIFICATE()->label)->get();
            foreach ($applications as $application) {
                WatchRemoteApplicationJob::dispatch($application);
            }
        })->everyTwoMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
