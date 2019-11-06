<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Utils\InboxMail;

class MailMessage extends Model
{
    const UPDATED_AT = null;

    protected $inboxMail;

    protected $parser;

    public $content_type;

    public $primaryKey = 'mail_id';

    public $fillable = ['message_id', 'file_name', 'date', 'subject', 'size'];

    public function froms() {
        return $this->hasMany(\App\Models\MailFrom::class, 'mail_id');
    }

    public function tos() {
        return $this->hasMany(\App\Models\MailTo::class, 'mail_id');
    }

    public function attachments() {
        return $this->hasMany(\App\Models\MailAttachment::class, 'mail_id');
    }

    public function users() {
        return $this->belongsToMany(\App\Models\User::class, 'mail_message_user', 'mail_id', 'user_id')->using(\App\Models\MailMessageUser::class);
    }

    protected function setParser() {
        if($this->parser != null) return;

        $this->parser = new \PhpMimeMailParser\Parser();

        $this->parser->setPath($this->getPath());
        /* maybe useless
        // Set content type
        foreach ($this->parser->getParts() as $part) {
            if(isset($part['content-type'])) {
                $this->content_type = $part['content-type'];
                break;
            }
        }*/
    }

    public function getParser() {
        $this->setParser();
        return $this->parser;
    }

    protected function getPath() {
        $path = base_path() . Storage::disk('local')->url('app/inbox/' . $this->file_name . '.eml');
        return $path;
    }

    /* may be useless
    public function getInboxMail() {
        if($this->inboxMail != null) {
            return $this->inboxMail;
        }
        $im = new InboxMail();

        $path = base_path() . Storage::disk('local')->url('app/inbox/' . $this->file_name . '.eml');

        $im->parse($path);

        $this->inboxMail = $im;

        return $this->inboxMail;
    }*/

    public function getMessageBody() {
        $this->setParser();
        return (!empty($this->parser->getMessageBody('html'))) ? $this->parser->getMessageBody('html') : $this->parser->getMessageBody();
    }

    public function sizeText($decimals = 2) {
        $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor(log($this->size, 1024));
        return sprintf("%.{$decimals}f ", $this->size / pow(1024, $factor)) . @$size[$factor];
    }
}
