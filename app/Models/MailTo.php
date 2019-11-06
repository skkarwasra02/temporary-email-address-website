<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MailMessage;

class MailTo extends Model
{
    public $timestamps = false;

    public $fillable = ['mail_id', 'display', 'address'];

    public function mailMessage() {
        return $this->belongsTo(MailMessage::class, 'mail_id');
    }
}
