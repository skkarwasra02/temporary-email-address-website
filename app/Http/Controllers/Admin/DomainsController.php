<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Domain;

class DomainsController extends Controller
{
    public function showDomains() {
        $data['active-sidebar-li'] = "domains-li";
        $data['domains'] = Domain::get();
        return view('admin.domains')->with('data', $data);
    }

    public function addDomain(Request $request) {
        $validate = $request->validate([
            'domain' => 'required|unique:domains,name',
            'expiry_date' => 'nullable|date',
            'added_by' => 'nullable',
            'type' => 'required',
            'status' => 'nullable'
        ]);
        $domain = new Domain;
        $domain->name = $request->domain;
        $domain->expiry_date = $request->expiry_date;
        $domain->added_by = $request->added_by;
        $domain->type = $request->type;
        $domain->status = $request->status;
        if($domain->save()) {
            return redirect('/admin/domains')->with('success', 'Successfully added new domain');
        }
        return redirect('/admin/domains')->with('error', 'Unknown Error');
    }

    public function editDomain(Request $request) {
        $validate = $request->validate([
            'domain_id' => 'required|exists:domains,domain_id',
            'expiry_date' => 'nullable|date',
            'added_by' => 'nullable',
            'type' => 'required',
            'status' => 'nullable'
        ]);
        $domain = Domain::where('domain_id', $request->domain_id)->first();
        $domain->expiry_date = $request->expiry_date;
        $domain->added_by = $request->added_by;
        $domain->type = $request->type;
        $domain->status = $request->status;
        if($domain->save()) {
            return redirect('/admin/domains')->with('success', 'Domain updated successfully');
        }
        return redirect('/admin/domains')->with('error', 'Unknown Error');
    }

    public function deleteDomain(Request $request) {
        $validate = $request->validate([
            'domain_id' => 'required|exists:domains,domain_id'
        ]);
        DB::transaction(function() use(&$request) {
            $domain = Domain::where('domain_id', $request->domain_id)->first();
            foreach ($domain->users as $user) {
                foreach ($user->mails as $mailMessage) {
                    $file_name = $mailMessage->file_name;
                    foreach ($mailMessage->froms as $from) {
                        $from->delete();
                    }
                    foreach ($mailMessage->tos as $to) {
                        $to->delete();
                    }
                    foreach ($mailMessage->attachments as $attachment) {
                        $attachment->delete();
                    }
                    $mailMessage->pivot->delete();
                    $mailMessage->delete();
                    // Delete mail file
                    $delete_file = Storage::disk('local')->delete('inbox/' . $file_name . '.eml');
                }
                // Delete user
                $user->delete();
            }
            // Delete domain
            $domain->delete();
        });
    }
}
