<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $primaryKey = 'ad_id';
    public $timestamps = false;
    protected $fillable = ['ad_name', 'ad_size', 'ad_code'];

    public static function getCode($ad_id) {
        $ad = Ad::where('ad_id', $ad_id)->first();
        return ($ad == null) ? false : $ad->ad_code;
    }

    public static function getRandomCode() {
        if(func_num_args() == 0) return false;
        $rand = mt_rand(0, func_num_args() - 1);
        $ad = Ad::where('ad_id', func_get_arg($rand))->first();
        return ($ad == null) ? false : $ad->ad_code;
    }
}
