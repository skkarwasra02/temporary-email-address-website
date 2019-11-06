<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MailMessage;

class MailsController extends Controller
{
    public function showMails(Request $request) {
        $data['active-sidebar-li'] = "mails-li";
        if(isset($request->start_date) && isset($request->end_date)) {
            $data['has-limits'] = true;
            $data['mails'] = MailMessage::whereBetween('created_at', [
                    date("Y-m-d",strtotime($request->input('start_date'))),
                    date("Y-m-d",strtotime($request->input('end_date')."+1 day"))
                ])
                ->get();
        }
        return view('admin.mails')->with('data', $data);
    }
}
