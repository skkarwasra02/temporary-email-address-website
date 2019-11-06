<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MailMessageUser extends Pivot
{
    public $table = "mail_message_user";

    public $timestamps = false;

    public $fillable = ['mail_id', 'user_id'];
}
