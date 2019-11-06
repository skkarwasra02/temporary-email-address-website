<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;
    
    protected $fillable = ['setting_name', 'setting_value'];

    public static function getSettingValue($setting_name) {
        $setting = Setting::where('setting_name', $setting_name)->first();
        return ($setting == null) ? false : $setting->setting_value;
    }

    public static function setSettingValue($setting_name, $setting_value) {
        $setting = Setting::where('setting_name', $setting_name)->first();
        if($setting == null) return false;
        $setting->setting_value = $setting_value;
        return ($setting->save()) ? true : false;
    }
}
