<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function showSettings() {
        $data['active-sidebar-li'] = "settings-li";
        $data['settings'] = Setting::class;
        return view('admin.settings')->with('data', $data);
    }

    public function saveSettings(Request $request) {
        if(isset($request->settings)) {
            foreach ($request->settings as $setting_name => $setting_value) {
                Setting::setSettingValue($setting_name, $setting_value);
            }
            return redirect('/admin/settings')->withSuccess('Successfully updated settings');
        }
        return redirect('/admin/settings')->withError('Unknown Error');
    }
}
