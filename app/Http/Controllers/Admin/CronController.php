<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\CronJob;
use App\Models\Setting;
use App\Models\MailMessage;
use App\Models\ComposeAttachment;
use Carbon\Carbon;

class CronController extends Controller
{

    public function showCronJobs() {
        $data['active-sidebar-li'] = "cron-jobs-li";
        $data['cron_jobs'] = CronJob::all();
        return view('admin.cronjobs')->with('data', $data);
    }

    public function editCron(Request $request) {
        $validate = $request->validate([
            'id' => 'required|exists:cron_jobs,id',
            'cron_schedule' => 'required',
            'status' => 'nullable'
        ]);
        $cron_job = CronJob::where('id', $request->id)->first();
        $cron_job->cron_schedule = $request->cron_schedule;
        $cron_job->status = $request->status;
        if($cron_job->save()) {
            return redirect('/admin/cron-jobs')->with('success', 'Cron updated successfully');
        }
        return redirect('/admin/cron-jobs')->with('error', 'Unknown Error');
    }

    public function deleteAttachments() {
        DB::transaction(function() {
            // Get expiry (hours)
            $expiry = Setting::getSettingValue('delete_attachments');
            if($expiry == false || $expiry == 0 || $expiry == null) return false;
            $attachments = ComposeAttachment::select('id', 'file_name', 'path')->where('created_at', '<=', Carbon::now()->subHours($expiry)->toDateTimeString());
            foreach ($attachments->get() as $att) {
                // Delete file
                Storage::delete($att->path);
                $att->delete();
            }

            // Update cron's last execution
            $execution = CronJob::where('cron_name', 'deleteAttachments')->first();
            $execution->last_execution = Carbon::now();
            $execution->save();
            return true;
        });
    }
}
