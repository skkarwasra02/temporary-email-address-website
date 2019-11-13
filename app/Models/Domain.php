<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Setting;

class Domain extends Model
{
    public $primaryKey = "domain_id";

    public $fillable = ["name", "expiry_date", 'added_by', "status"];

    public function users() {
        return $this->hasMany(\App\Models\User::class, 'domain_id');
    }

    public static function selectActiveRandomDomain($receive = true) {
        if($receive) {
            $domain = Domain::where('status', 'active')
                                ->where('type', 'receive')
                                ->orWhere('type', 'send_receive')
                                ->inRandomOrder()
                                ->first();
        } else {
            $domain = Domain::where('status', 'active')
                                ->where('type', 'send')
                                ->orWhere('type', 'send_receive')
                                ->inRandomOrder()
                                ->first();
        }
        return $domain;
    }

    public static function getDomainNameFromEmail($email) {
        $emailArr = explode('@', $email);
        if(count($emailArr) != 2) {
            return false;
        }
        $domain = $emailArr[1];
        return $domain;
    }

    public static function validateDomainFromEmail($email) {
        $emailArr = explode('@', $email);
        if(count($emailArr) != 2) {
            return false;
        }
        $name = $emailArr[1];
        $domain = Domain::where('name', $name)->first();
        return ($domain == null) ? false : $domain;
    }

    public static function validateDomain($domainName) {
        $ms = Setting::getSettingValue("mail_server");
        if($ms == null || empty($ms)) {
            $domain = self::firstOrNew([
                'name' => $domainName
            ]);
            $domain->mx_checked_at = now();
            $domain->status = "active";
            if(!$domain->exists) {
                $domain->type = 'receive';
            }
            $domain->save();
            return $domain;
        }
        // Get MX records
        $mx = self::getmxrecords($domainName);
        //dd($mx);
        if(!count($mx)) {
            // Update domains table if exists
            $domain = self::where('name', $domainName)->first();
            if($domain != null) {
                $domain->mx_checked_at = now();
                $domain->status = "inactive";
                $domain->save();
                return false;
            }
        }
        foreach($mx as $record) {
            if($record["host"] == $ms || $record["host"] == $ms . "."  || strpos($record['host'], $ms)) {
                $domain = self::firstOrNew([
                    'name' => $domainName
                ]);
                $domain->mx_checked_at = now();
                $domain->status = "active";
                if(!$domain->exists) {
                    $domain->type = 'receive';
                }
                $domain->save();
                return $domain;
            }
        }
        $domain = self::where('name', $domainName)->first();
        if($domain != null) {
            $domain->mx_checked_at = now();
            $domain->status = "inactive";
            $domain->save();
        }
        return false;
    }

    public static function getmxrecords($host) {
        $mxhosts = null;
        $mxweight = null;
        $mx = [];
        $mxr = getmxrr($host, $mxhosts, $mxweight);
        if(!$mxr || $mxhosts == null || !count($mxhosts)) return $mx;
        for($i = 0; $i < count($mxhosts); $i++) {
            $mx[$i] = [
                "host" => $mxhosts[$i],
                "weight" => $mxweight[$i]
            ];
        }
        return $mx;
    }
}
