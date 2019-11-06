<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AccountsController extends Controller
{
    public function showAccounts(Request $request) {
        $data['active-sidebar-li'] = "accounts-li";
        $data['accounts'] = User::get();
        return view('admin.accounts')->with('data', $data);
    }

    public function deleteAccountById(Request $request, $account_id) {
        // Validate
        $validator = Validator::make(['account_id' => $account_id], [
            'account_id' => 'exists:users,user_id'
        ]);
        if($validator->fails()) {
            return redirect('/admin/accounts')->withErrors($validator)->withInput();
        }
        DB::transaction(function () use(&$account_id) {
            $user = User::where('user_id', $account_id)->first();
            if($user == null) {
                return redirect()->back()->withError('Account not found');
            }
            foreach ($user->mails as $mailMessage) {
                $users = count($mailMessage->users);
                $user->mails()->detach($mailMessage->mail_id);
                if($users == 1) {
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
                    $mailMessage->delete();
                    // Delete mail file
                    $delete_file = Storage::disk('local')->delete('inbox/' . $file_name . '.eml');
                }
            }
            // Delete user
            $user->delete();
        });
        return redirect()->back()->withSuccess('Account deleted successfully');
    }
}
