<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use App\Models\Domain;
use App\Models\MailMessage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class InboxController extends Controller
{
    public function main(Request $request) {
        if($request->cookie('ea') == null) {
            $user = User::createRandomUser(Domain::selectActiveRandomDomain());
            Cookie::queue('ea', $user->email);
        } else {
            $email = $request->cookie('ea');
            $user = User::where('email', $email)->first();
            if($user == null) {
                $user = User::createRandomUser(Domain::selectActiveRandomDomain());
                Cookie::queue('ea', $user->email);
            }
            if($user->inbox_size > 0) {
                return redirect()->route('inbox');
            }
        }
        $data = array(
            'user' => $user,
            'domain' => Domain::class,
            'address_error' => ""
        );
        return view('main')->with('data', $data);
    }

    public function inbox(Request $request, $file_name = null) {
        if($request->cookie('ea') == null) {
            return redirect()->route('main');
        }
        $email = $request->cookie('ea');
        $user = User::where('email', $email)->first();
        if($user == null) {
            return redirect()->route('main');
        }
        if($user->inbox_size == 0) {
            return redirect()->route('main');
        }
        $data = array(
            'user' => $user,
            'domain' => Domain::class,
            'address_error' => ""
        );
        // Check for valid domain
        $emailArr = explode('@', $email);

        $domain = Domain::validateDomain($emailArr[1]);
        if(!$domain) {
            $data['address_error'] = "Invalid domain name";
        }
        if($file_name != null) {
            $search = $user->mails()->where('file_name', $file_name)->first();
            if($search == null) {
                return redirect()->route('inbox');
            }
            $data['file_name'] = $file_name;
        }
        return view('main')->with('data', $data);
    }

    public function random(Request $request) {
        $cookie = Cookie::forget('ea');
        return redirect()->route('main')->withCookie($cookie);
    }

    public function downloadMailPage($file_name) {
        $data['title'] = "Download Mail";

        $mailMessage = MailMessage::where('file_name', $file_name)->first();
        if($mailMessage == null || !Storage::disk('local')->exists('inbox/' . $file_name . '.eml')) {
            $data['file-found'] = false;
            return view('download')->with('data', $data);
        }

        $data['file']['Subject'] = $mailMessage->subject;
        $data['file']['Size'] = $mailMessage->sizeText();

        // return response()->download(base_path() . Storage::disk('local')->url('app/inbox/' . $file_name . '.eml'));

        return view('download')->with('data', $data);
    }

    public function downloadMail($file_name) {
        $data['title'] = "Download Mail";

        $mailMessage = MailMessage::where('file_name', $file_name)->first();
        if($mailMessage == null || !Storage::disk('local')->exists('inbox/' . $file_name . '.eml')) {
            $data['file-found'] = false;
            return view('download')->with('data', $data);
        }

        return response()->download(base_path() . Storage::disk('local')->url('app/inbox/' . $file_name . '.eml'), $mailMessage->subject . ".eml");
    }

    public function deleteMail($file_name) {
        $mailMessage = MailMessage::where('file_name', $file_name)->first();
        if($mailMessage == null || !Storage::disk('local')->exists('inbox/' . $file_name . '.eml')) {
            return abort(404);
        }

        DB::transaction(function () use(&$mailMessage, &$file_name) {
            // Delete froms
            $mailMessage->froms()->delete();

            // Delete tos
            $mailMessage->tos()->delete();

            // Delete attachments
            $mailMessage->attachments()->delete();

            $users = $mailMessage->users;
            foreach($users as $user) {
                $user->inbox_size--;
                $user->save();

                $user->pivot->delete();
            }

            $mailMessage->delete();

            // Delete mail file
            $delete = Storage::disk('local')->delete('inbox/' . $file_name . '.eml');
        });

        return redirect()->route('main');
    }

    public function downloadAttachmentPage($file_name, $name) {
        $data['title'] = "Download Attachment";

        $mailMessage = MailMessage::where('file_name', $file_name)->first();
        if($mailMessage == null || !Storage::disk('local')->exists('inbox/' . $file_name . '.eml')) {
            $data['file-found'] = false;
            return view('download')->with('data', $data);
        }

        $attachment = $mailMessage->attachments()->where('name', $name)->first();
        if($attachment == null) {
            $data['file-found'] = false;
            return view('download')->with('data', $data);
        }

        $data['file']['Name'] = $attachment->name;
        $data['file']['Size'] = $attachment->sizeText();

        //return response()->download(base_path() . Storage::disk('local')->url('app/inbox/' . $file_name . '.eml'));

        return view('download')->with('data', $data);
    }

    public function downloadAttachment($file_name, $name) {
        $data['title'] = "Download Attachment";

        $mailMessage = MailMessage::where('file_name', $file_name)->first();
        if($mailMessage == null || !Storage::disk('local')->exists('inbox/' . $file_name . '.eml')) {
            $data['file-found'] = false;
            return view('download')->with('data', $data);
        }

        $attachment = $mailMessage->attachments()->where('name', $name)->first();
        if($attachment == null) {
            $data['file-found'] = false;
            return view('download')->with('data', $data);
        }

        $parser = $mailMessage->getParser();
        foreach ($parser->getAttachments() as $att) {
            if($att->getFileName() != $name) continue;
            return response()->streamDownload(function() use($name, $att) {
                $stream = $att->getStream();
                $ct = "";
                fseek($stream, 0);
                while(!feof($stream)) {
                    $ct .= fread($stream, 100);
                }
                echo $ct;
            }, $name);
            break;
        }
    }
}
