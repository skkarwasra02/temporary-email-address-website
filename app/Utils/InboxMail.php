<?php

namespace App\Utils;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\MailMessage;
use App\Models\MailTo;
use App\Models\MailFrom;
use App\Models\MailAttachment;
use App\Models\MailMessageUser;
use Illuminate\Support\Facades\DB;

class InboxMail
{

    private $message_id;

    private $date;

    private $subject;

    private $size;

    private $tos = [];

    private $froms = [];

    private $attachments = [];

    private $mail_id;

    private $file_name;

    private $created_at;

    private $stream;

    private $content_type;

    private $message_body;

    private $parser;

    public function setMessageId($message_id) {
        $this->message_id = $message_id;
    }

    public function getMessageId() {
        return $this->message_id;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }

    public function setTos($tos) {
        $this->tos = $tos;
    }

    public function getTos() {
        return $this->tos;
    }

    public function setFroms($froms) {
        $this->froms = $froms;
    }

    public function getFroms() {
        return $this->froms;
    }

    public function setAttachments($attachments) {
        $this->attachments = $attachments;
    }

    public function getAttachments() {
        return $this->attachments;
    }

    public function setMailId($mail_id) {
        $this->mail_id = $mail_id;
    }

    public function getMailId() {
        return $this->mail_id;
    }

    public function setFileName($file_name) {
        $this->file_name = $file_name;
    }

    public function getFileName() {
        return $this->file_name;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getMessageBody() {
        return $this->message_body;
    }

    public function setStream($stream) {
        $this->stream = $stream;
    }

    public function getStream() {
        return $this->stream;
    }

    public function getParser() {
        return $this->parser;
    }

    public function save()
    {
        // Check for existing message id
        $mailMessage = MailMessage::where('message_id', $this->message_id)->first();
        if($mailMessage != null)
        {
            return false;
        }

        // Begin DB transaction
        DB::beginTransaction();

        $stat = fstat($this->stream);

        $mailMessage = new MailMessage();
        $mailMessage->message_id = $this->message_id;
        $mailMessage->file_name = $this->file_name;
        $mailMessage->subject = $this->subject;
        if($stat) {
            $mailMessage->size = $stat['size'];
        }
        $mailMessage->save();

        // Save tos and connection with user
        foreach ($this->getTos() as $to) {
            $tos = new MailTo();
            $tos->mailMessage()->associate($mailMessage);
            $tos->display = $to['display'];
            $tos->address = $to['address'];
            $tos->save();

            $user = User::where('email', $to['address'])->first();
            if($user != null) {
                $mailMessageUser = new MailMessageUser();
                $mailMessageUser->mail_id = $mailMessage->mail_id;
                $mailMessageUser->user_id = $user->user_id;
                $mailMessageUser->save();
                $user->inbox_size++;
                $user->save();
            }
        }
        // Save froms
        foreach ($this->getFroms() as $from) {
            $froms = new MailFrom();
            $froms->mailMessage()->associate($mailMessage);
            $froms->display = $from['display'];
            $froms->address = $from['address'];
            $froms->save();
        }
        // Save attachments
        foreach ($this->getAttachments() as $att) {
            $attachment = new MailAttachment();
            $attachment->mailMessage()->associate($mailMessage);
            $attachment->name = $att->getFilename();
            $attachment->content_type = $att->getContentType();
            // Get attachment stat
            $fstat = fstat($att->getStream());
            if($fstat != null) {
                $attachment->size = $fstat['size'];
            }
            $attachment->save();
        }

        // Save stream as eml file
        if($this->stream) {
            // Create directory for this mail if not exists
            $local_path = 'inbox/';
            if(!Storage::disk('local')->exists($local_path)) {
                Storage::disk('local')->makeDirectory($local_path);
            }
            $full_path = base_path() . Storage::disk('local')->url('app/' . $local_path);
            $eml = fopen($full_path . $mailMessage->file_name . '.eml', 'w+b');
            fseek($this->stream, 0, SEEK_SET);
            while(!feof($this->stream))  {
                fwrite($eml, fgets($this->stream));
            }
        }

        DB::commit();
    }

    public function parse($source, $path = true) {
        $parser = new \PhpMimeMailParser\Parser();

        // Set stream or path
        if($path) {
            $this->path = $source;
            $parser->setPath($source);
        } else {
            $this->stream = $source;
            $parser->setStream($source);
        }

        // Set content type
        foreach ($parser->getParts() as $part) {
            if(isset($part['content-type'])) {
                $this->content_type = $part['content-type'];
                break;
            }
        }

        // Set message body
        if($this->content_type == 'text/html') {
            $this->message_body = $parser->getMessageBody('html');
        } else {
            $this->message_body = $parser->getMessageBody();
        }

        $this->parser = $parser;

        return $this->parser;
    }

}
