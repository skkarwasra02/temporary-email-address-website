<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Models\User;
use App\Models\MailMessage;

class DashboardController extends Controller
{
    public function dashboard() {
        $data['active-sidebar-li'] = "dashboard-li";

        // Today's stats
        $data['today-email-account'] = User::whereDate('created_at', Carbon::today())->get()->count();
        $data['today-email-received'] = MailMessage::whereDate('created_at', Carbon::today())->get()->count();
        $data['today-emails-size'] = number_format((MailMessage::select('size')->whereDate('created_at', Carbon::today())->sum('size'))/1024/1024, 3);

        // Weekly stats
        $data['weekly-email-accounts'] = User::whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->get()->count();
        $data['weekly-email-received'] = MailMessage::whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->get()->count();
        $data['weekly-emails-size'] = number_format((MailMessage::select('size')->whereDate('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->sum('size'))/1024/1024, 3);

        // Total
        $data['total-email-accounts'] = User::select('user_id')->get()->count();
        $data['total-email-received'] = MailMessage::select('mail_id')->get()->count();
        $data['total-emails-size'] =  number_format((MailMessage::select('size')->sum('size'))/1024/1024, 3);

        return view('admin.dashboard')->with('data', $data);
    }
}
