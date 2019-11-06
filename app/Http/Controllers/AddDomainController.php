<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddDomainController extends Controller
{
    public function showPage() {
        return view('add-domain');
    }

    public function checkMX(Request $request) {
        $validate = $request->validate([
            'domain' => 'required'
        ]);
        $mx = getmxrr($request->domain, $mxhosts, $weight);
        $mxrecords = [];
        $i = 0;
        if($mxhosts != null) {
            foreach ($mxhosts as $host) {
                $mxrecords[] = array(
                    'mxhost' => $host,
                    'weight' => $weight[$i]
                );
                $i++;
            }
        }
        return view('add-domain')->with([
            'mxrecords' => $mxrecords
        ]);
    }
}
