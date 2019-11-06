<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Support;

class SupportController extends Controller
{
    public function showSupportPage() {
        $data['active-sidebar-li'] = "support-li";
        $data['supports'] = Support::all();
        return view('admin.support')->with('data', $data);
    }

    public function changeResolveStatus(Request $request, $support_id, $resolve) {
        $support = Support::where('id', $support_id)->first();
        if($support != null) {
            if($resolve != 'yes' && $resolve != 'no') {
                return redirect('/admin/support')->withError('Invalid parameter');
            }
            $support->resolved = $resolve;
            $support->save();
            return redirect('/admin/support')->withSuccess('Successfully updated resolve status');
        }
        return redirect('/admin/support')->withError('Support ticket not found');
    }

    public function deleteSupportRequest(Request $request, $support_id) {
        $support = Support::where('id', $support_id)->first();
        if($support != null) {
            $support->delete();
            return redirect('/admin/support')->withSuccess('Successfully deleted support request');
        }
        return redirect('/admin/support')->withError('Support ticket not found');
    }
}
