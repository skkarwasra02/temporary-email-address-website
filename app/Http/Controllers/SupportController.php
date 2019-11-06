<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support;

class SupportController extends Controller
{
    public function showPage() {
        return view('support');
    }

    public function newSupportRequest(Request $request) {
        $validate = $request->validate([
            'name' => 'required|min:3|max:25',
            'email' => 'required|email',
            'message' => 'required'
        ]);
        $support = new Support;
        $support->name = $request->name;
        $support->email = $request->email;
        $support->message = $request->message;
        if($support->save()) {
            return redirect('/contact-us')->withSuccess("Successfully submitted support request. We will respond you on your email.");
        }
        return redirect('/contact-us')->withError("Unknown Error");
    }
}
