<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SentMail;

class SentMailsController extends Controller
{
    public function showSentMails(Request $request) {
        $data['active-sidebar-li'] = "sent-mails-li";
        if(isset($request->start_date) && isset($request->end_date)) {
            $data['has-limits'] = true;
            $data['sent_mails'] = SentMail::whereBetween('created_at', [
                    date("Y-m-d",strtotime($request->input('start_date'))),
                    date("Y-m-d",strtotime($request->input('end_date')."+1 day"))
                ])
                ->get();
        }
        return view('admin.sentmails')->with('data', $data);
    }
}
