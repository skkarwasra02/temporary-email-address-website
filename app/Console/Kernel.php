<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\CronJob;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // deleteAttachments Cron
        // Get cron expression and status
        try {
            $deleteAttachmentCron = CronJob::where('cron_name', 'deleteAttachments')->first();
        } catch(\Illuminate\Database\QueryException $e) {
            $deleteAttachmentCron = null;
        }
        if($deleteAttachmentCron != null) {
            if($deleteAttachmentCron->status == 'active') {
                $schedule->call('\App\Http\Controllers\Admin\CronController@deleteAttachments')
                        ->cron($deleteAttachmentCron->cron_schedule);
            }
        }
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
