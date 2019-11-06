<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ComposeAttachment;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $composeToken;
    public $messageFrom;
    public $messageTo;
    public $messageSubject;
    public $messageBody;
    public $reportKey;
    public $senderIP;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($composeToken, $from, $to, $subject, $messageBody, $report_key, $ip)
    {
        $this->composeToken = $composeToken;
        $this->messageFrom = $from;
        $this->messageTo = $to;
        $this->messageSubject = $subject;
        $this->reportKey = $report_key;
        $this->messageBody = $messageBody . "\r\n\r\n\r\n\r\nSent using " . config("app.name") . "\r\nReport: " . url('report/?r=' . $report_key);
        $this->senderIP = $ip;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from($this->messageFrom)
            ->to($this->messageTo)
            ->subject($this->messageSubject)
            ->text('layouts.sendmail');

        // Check for attachments
        $cas = ComposeAttachment::where('compose_token', $this->composeToken)->get();
        foreach ($cas as $ca) {
            $this->attachFromStorage($ca->path, $ca->file_name);
        }

        // Set custom headers
        $this->withSwiftMessage(function ($message) {
            if($this->senderIP != null) {
                $message->getHeaders()
                        ->addTextHeader('X-Originating-IP', $this->senderIP);
            }
        });
        return $this;
    }
}
