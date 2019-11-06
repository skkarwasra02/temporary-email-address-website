<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailAttachment extends Model
{
    public $timestamps = false;

    public $fillable = ['mail_id', 'name', 'content_type', 'size'];

    public function mailMessage() {
        return $this->belongsTo(MailMessage::class, 'mail_id');
    }

    public function sizeText($decimals = 2) {
        $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor(log($this->size, 1024));
        return sprintf("%.{$decimals}f ", $this->size / pow(1024, $factor)) . @$size[$factor];
    }
}
