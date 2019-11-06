<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailFrom extends Model
{
    public $timestamps = false;

    public $fillable = ['mail_id', 'display', 'address'];

    public function mailMessage() {
        return $this->belongsTo(MailMessage::class, 'mail_id');
    }
}
