<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Utils\InboxMail;
use App\Models\MailMessage;
use Illuminate\Support\Str;

class ReceiveMailController extends Controller
{
    public function receiveMail(Request $request)
    {
        $mailResource = fopen('php://input', 'r');
        // Test mail resource
        //$mailResource = fopen($_FILES['email']['tmp_name'], 'r');

        // Generate random file name
        $file_name = Str::random(16);
        while(MailMessage::where('file_name', $file_name)->first() != null) {
            $file_name = Str::random(16);
        }

        $parser = new \PhpMimeMailParser\Parser();
        $parser->setStream($mailResource);

        // Create new mail object
        $mail = new InboxMail();

        $mail->setMessageId($parser->getHeader('Message-ID'));

        $mail->setFileName($file_name);

        $mail->setSubject($parser->getHeader('Subject'));

        $mail->setTos($parser->getAddresses('to'));

        $mail->setFroms($parser->getAddresses('from'));

        $mail->setAttachments($parser->getAttachments());

        $mail->setStream($parser->getStream());

        $mail->save();
    }
}
