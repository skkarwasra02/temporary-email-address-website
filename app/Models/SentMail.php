<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AbuseReport;

class SentMail extends Model
{
    const UPDATED_AT = null;

    public $fillable = ['from', 'to', 'ip', 'report_key', 'size'];

    public static function generateReportKey($len = 16) {
        $characters = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM=";
        $charactersLength = strlen($characters);
        $key = '';
        for ($i = 0; $i < $len; $i++) {
            $key .= $characters[rand(0, $charactersLength - 1)];
        }
        return $key;
    }

    public function report() {
        return $this->hasOne(AbuseReport::class, 'against', 'id');
    }
}
