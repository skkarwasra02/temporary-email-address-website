<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MailMessage;
use App\Models\Domain;
use App\Models\Setting;

class User extends Model
{
    public $primaryKey = 'user_id';

    protected $fillable = [
        'email', 'domain_id', 'ip', 'last_login', 'inbox_size', 'status'
    ];

    protected $attributes = [
        'inbox_size' => 0,
        'status' => 'active'
    ];

    public function mails() {
        return $this->belongsToMany(\App\Models\MailMessage::class, 'mail_message_user', 'user_id', 'mail_id')->using(\App\Models\MailMessageUser::class);
    }

    public function domain() {
        return $this->belongsTo(\App\Models\Domain::class, 'domain_id');
    }

    public function getUsernameAttribute() {
        $email = explode('@', $this->email);
        $username = $email[0];
        return $username;
    }

    public static function createRandomUser(Domain $domain, $dontsave = false) {
        // Generate random username
        $foundUniqueUsername = false;
        while(!$foundUniqueUsername) {
            $unamelength = Setting::getSettingValue('random_username_length');
            $characters = Setting::getSettingValue('random_username_characters');
            $charactersLength = strlen($characters);
            $username = '';
            for ($i = 0; $i < $unamelength; $i++) {
                $username .= $characters[rand(0, $charactersLength - 1)];
            }
            $email = User::where('email', 'LIKE', $username . '%')->get()->toArray();
            if(count($email) == 0) $foundUniqueUsername = true;
        }
        $email = $username . '@' . $domain->name;
        $user = User::firstOrNew([
            'email' => $email,
            'domain_id' => $domain->domain_id
        ]);
        $user->ip = request()->ip();
        $user->last_login = now();
        if(!$dontsave) {
            $user->save();
        }
        return $user;
    }

    public static function getUsernameFromEmail($email) {
        $emailArr = explode('@', $email);
        if(count($emailArr) != 2) {
            return false;
        }
        $username = $emailArr[0];
        return $username;
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
    }

}
