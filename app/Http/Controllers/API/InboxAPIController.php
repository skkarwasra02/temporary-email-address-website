<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Support\Facades\Cookie;

class InboxAPIController extends Controller
{
    public function getInboxSize(Request $request) {
        $request->validate([
            "email" => "required"
        ]);
        $user = User::where('email', $request->email)->first();
        if($user == null) {
            $data['inbox_size'] = 0;
        } else {
            $data['inbox_size'] = $user->inbox_size;
        }
        $data['status'] = 'success';
        return response()->json($data);
    }

    public function openEmail(Request $request) {
        $request->validate([
            "email" => "required|email"
        ]);
        $data = [];

        $emailArr = explode('@', $request->email);

        $domain = Domain::validateDomain($emailArr[1]);
        if(!$domain) {
            $data['status'] = "error";
            $data['message'] = "Invalid domain name";
            // Check for previous active user
            $user = User::where('email', $request->email)->first();
            if($user != null) {
                $data['inbox_size'] = $user->inbox_size;
                Cookie::queue('ea', $user->email);
            } else {
                $data['inbox_size'] = 0;
            }
            return response()->json($data);
        }
        // Validate email
        if(!User::validateEmail($request->email)) {
            $data['status'] = "error";
            $data['message'] = "Invalid email";
            $data['inbox_size'] = 0;
            return response()->json($data);
        }
        $user = User::firstOrNew([
            'email' => $request->email,
            'domain_id' => $domain->domain_id
        ]);
        $user->last_login = now();
        if (!$user->exists) {
            $user->ip = request()->ip();
            if($user->save()) {
                $data['status'] = 'success';
            } else {
                $data['status'] = "error";
                $data['message'] = "Unknown error";
                return response()->json($data);
            }
        } else {
            $data['status'] = 'success';
        }
        Cookie::queue('ea', $user->email);
        $data['inbox_size'] = $user->inbox_size;
        return response()->json($data);
    }

    public function softSearchDomain(Request $request) {
        $validate = $request->validate([
            'term' => 'required'
        ]);
        $result = array();
        // Find domains in database
        $domains = Domain::where('domain', 'LIKE', '%' . $request->term . '%')->where('type', 'receive')->orWhere('type', 'send_receive')->get();
        foreach ($domains as $domain) {
            $result[] = $domain->domain;
        }
        return response()->json($result);
    }
}
