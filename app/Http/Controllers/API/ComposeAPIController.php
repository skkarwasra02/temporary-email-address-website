<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;

class ComposeAPIController extends Controller
{
    public function openEmail(Request $request) {
        $request->validate([
            "email" => "required|email"
        ]);
        $data = [];

        $emailArr = explode('@', $request->email);

        $domain = Domain::where('name', $emailArr[1])->where('type', 'send')->orWhere('type', 'send_receive')->first();
        if($domain == null) {
            $data['status'] = "error";
            $data['message'] = "Invalid domain name";
            return response()->json($data);
        }
        // Validate email
        if(!User::validateEmail($request->email)) {
            $data['status'] = "error";
            $data['message'] = "Invalid email";
            return response()->json($data);
        }

        $user = new User;
        $user->email = $request->email;
        Cookie::queue('sea', $request->email);
        $request->session()->put('sea', $user->email);
        $data['status'] = 'success';
        return response()->json($data);
    }
}
