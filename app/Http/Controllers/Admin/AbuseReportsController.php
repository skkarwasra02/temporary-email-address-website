<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AbuseReport;

class AbuseReportsController extends Controller
{
    public function showReports(Request $request) {
        $data['active-sidebar-li'] = "abuse-reports-li";
        if(isset($request->start_date) && isset($request->end_date)) {
            $data['has-limits'] = true;
            $data['abuse_reports'] = AbuseReport::whereBetween('created_at', [
                    date("Y-m-d",strtotime($request->input('start_date'))),
                    date("Y-m-d",strtotime($request->input('end_date')."+1 day"))
                ])
                ->get();
        }
        return view('admin.abuse-reports')->with('data', $data);
    }
}
