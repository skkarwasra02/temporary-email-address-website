<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ad;

class AdvertisingController extends Controller
{
    public function showAdvertisingPage() {
        $data['active-sidebar-li'] = "advertising-li";
        return view('admin.advertising')->with('data', $data);
    }

    public function addAd(Request $request) {
        $validate = $request->validate([
            'ad_code' => 'required'
        ]);
        $ad = new Ad;
        $ad->ad_name = $request->ad_name;
        $ad->ad_size = $request->ad_size;
        $ad->ad_code = $request->ad_code;
        if($ad->save()) {
            return redirect('/admin/advertising')->with('success', 'Successfully added new ad');
        }
        return redirect('/admin/advertising')->with('error', 'Unknown Error');
    }

    public function editAd(Request $request) {
        $validate = $request->validate([
            'ad_id' => 'required|exists:ads,ad_id',
            'ad_name' => 'nullable',
            'ad_size' => 'nullable',
            'ad_code' => 'required'
        ]);
        $ad = Ad::where('ad_id', $request->ad_id)->first();
        $ad->ad_name = $request->ad_name;
        $ad->ad_size = $request->ad_size;
        $ad->ad_code = $request->ad_code;
        if($ad->save()) {
            return redirect('/admin/advertising')->with('success', 'Ad updated successfully');
        }
        return redirect('/admin/advertising')->with('error', 'Unknown Error');
    }

    public function deleteAd(Request $request) {
        $validate = $request->validate([
            'ad_id' => 'required|exists:ads,ad_id'
        ]);
        $ad = Ad::where('ad_id', $request->ad_id)->first();
        if($ad->delete()) {
            return redirect('/admin/advertising')->with('success', 'Ad deleted successfully');
        }
        return redirect('/admin/advertising')->with('error', 'Unknown error');
    }
}
