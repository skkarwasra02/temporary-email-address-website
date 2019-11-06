<?php

use Illuminate\Database\Seeder;
use App\Models\CronJob;

class CronJobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cron_job = new CronJob;
        $cron_job->cron_name = "deleteAttachments";
        $cron_job->cron_schedule = "0 1 * * *";
        $cron_job->save();
    }
}
