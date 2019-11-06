<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\Admin;

class ProfileController extends Controller
{
    public function showProfileSetting() {
        $data['active-sidebar-li'] = "profile-li";
        return view('admin.profile')->with('data', $data);
    }

    public function updateProfileSetting(Request $request) {
        $request->validate([
            "email" => "required|email",
            "password" => "confirmed",
            "opassword" => "required"

        ]);
        $adminAuth = Auth::user();
        $admin = Admin::where("email", $adminAuth->email)->first();
        if(Hash::check($request->opassword, $admin->password)) {
            $admin->email = $request->email;
            if(isset($request->password)) {
                $admin->password = Hash::make($request->password);
            }
            $admin->save();
            return redirect('/admin/profile')->withSuccess("Profile updated successfully. Please login again.");
        }
        return redirect('/admin/profile')->withError('Old password don\'t match');
    }

    // Password reset
    public function resetPassword(Request $request) {
        $request->validate([
            "email" => "required|exists:admins,email",
            "password" => "required|min:6",
            "dbpassword" => "required"
        ]);
        if($request->dbpassword == env("DB_PASSWORD")) {
            $admin = Admin::where("email", $request->email)->first();
            $admin->password = Hash::make($request->password);
            $admin->save();
            return redirect('/admin/reset')->withSuccess("Password changed successfully");
        }
        return redirect('/admin/reset')->withError("Invalid database password");
    }
}
