<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use App\Models\Domain;
use App\Models\ComposeAttachment;
use App\Mail\SendMail;
use App\Models\SentMail;
use App\Models\AbuseReport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Swift_Message;

class ComposeController extends Controller
{
    public function showComposePage(Request $request) {
        $data = [];
        if(!$request->session()->has('sea')) {
            $user = User::createRandomUser(Domain::selectActiveRandomDomain(false), true);
            $request->session()->put('sea', $user->email);
        } else {
            $user = new User;
            $user->email = $request->session()->get('sea');
            $user->ip = $request->ip();
        }
        //Cookie::queue('sea', $user->email);
        // Generate compose_key
        $data['compose_token'] = self::generateComposeToken();
        $data['user'] = $user;
        $data['domain'] = Domain::class;

        return view('compose')->with('data', $data);
    }

    public function send(Request $request) {
        $validator = Validator::make($request->all(), [
            'compose_token' => [
                'required',
                'min:8',
                'max:8',
            ],
            'from' => 'required',
            'to' => 'required',
            'subject' => 'required'
        ], [
            'compose_token.required' => "Invalid compose token.",
            'compose_token.min' => "Invalid compose token.",
            'compose_token.max' => "Invalid compose token."
        ])->validate();

        // Validate email
        if(!User::validateEmail($request->from)) {
            return redirect()->route('compose')->withError("Invalid your email address");
        }

        if(!filter_var($request->to, FILTER_VALIDATE_EMAIL)) {
            return redirect()->route('compose')->withError("Invalid recipient's email address");
        }

        /////////////// Please do more on validation

        // Check for reports
        $sms = SentMail::where('to', $request->to)->get();
        foreach ($sms as $sm) {
            $report = $sm->report;
            if($report == null) continue;
            if($report->block_all == 'yes' || $sm->from == $request->from) {
                return redirect()->route('compose')->withError('Sorry, we are not allowed to send mail to this recipient.');
            }
        }

        $report_key = SentMail::generateReportKey();

        $sendmail = new SendMail($request->compose_token, $request->from, $request->to, $request->subject, $request->message, $report_key, $request->ip());

        $mail = Mail::queue($sendmail);
        if($request->session()->has('send-error')) {
            return redirect()->route('compose')->withError($request->session()->get('send-error'));
        }
        return redirect()->route('compose')->withSuccess('Mail sent successfully');
    }

    public function upload(Request $request) {
        $validator = Validator::make($request->all(), [
            'compose_token' => [
                'required',
                'min:8',
                'max:8',
            ],
            'attachment' => 'required|max:25600', // Max upload size in KB
        ], [
            'compose_token.required' => "Invalid compose token.",
            'compose_token.min' => "Invalid compose token.",
            'compose_token.max' => "Invalid compose token."
        ])->validate();
        $file_name = $request->file('attachment')->getClientOriginalName();

        // Create directory for this attachment if not exists
        $local_path = 'uploads/';
        if(!Storage::disk('local')->exists($local_path)) {
            Storage::disk('local')->makeDirectory($local_path);
        }

        // Store file
        $path = $request->file('attachment')->store($local_path);
        $ca = new ComposeAttachment;
        $ca->compose_token = $request->compose_token;
        $ca->file_name = $file_name;
        $ca->ip = $request->ip();
        $ca->path = $path;
        $ca->size = $request->file('attachment')->getSize();
        $ca->save();
    }

    public function deleteUpload(Request $request) {
        $validator = Validator::make($request->all(), [
            'compose_token' => [
                'required',
                'min:8',
                'max:8',
            ],
            'attachment_name' => 'required|exists:compose_attachments,file_name', // Max upload size in KB
        ], [
            'compose_token.required' => "Invalid compose token.",
            'compose_token.min' => "Invalid compose token.",
            'compose_token.max' => "Invalid compose token."
        ])->validate();

        $ca = ComposeAttachment::where('file_name', $request->attachment_name)
                        ->where('compose_token', $request->compose_token)
                        ->first();
        // Delete stored file
        Storage::delete($ca->path);
        $ca->delete();
    }

    public function reportPage(Request $request) {
        $validate = $request->validate([
            "r" => "required|exists:sent_mails,report_key"
        ]);
        $sentmail = SentMail::where('report_key', $request->r)->first();
        $data['from'] = $sentmail->to;
        return view('report')->with('data', $data);
    }

    public function report(Request $request) {
        $validate = $request->validate([
            "report_key" => "required|exists:sent_mails,report_key",
            "message" => "nullable"
        ]);
        $sentmail = SentMail::where('report_key', $request->report_key)->first();

        // Check if already reported
        $check = AbuseReport::where('against', $sentmail->id)->first();
        if($check != null) {
            return redirect()->back()->withSuccess('Report submitted successfully. You will not receive any mails from this address or service as you selected.');
        }

        $report = new AbuseReport;
        $report->against = $sentmail->id;
        $report->message = $request->message;
        if($request->block_all == 'yes') {
            $report->block_all = 'yes';
        }
        $report->save();
        return redirect()->back()->withSuccess('Report submitted successfully. You will not receive any mails from this address or service as you selected.');
    }

    public static function generateComposeToken($len = 8) {
        $characters = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
        $charactersLength = strlen($characters);
        $token = '';
        for ($i = 0; $i < $len; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }
        return $token;
    }
}
