@extends('layouts.app')

@section('title')
<title>{{ config('app.name', 'Temporary Address') }} - Temporary Email Address</title>
@endsection

@section('css')
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
<style>
    .mht {
        text-align: left;
    }
    .mht td {
        padding-left: 20px;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 16px;
        font-family: monospace;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript">
    var data = {
        email: '{{ $data['user']->email }}',
        inbox_size: '{{ $data['user']->inbox_size }}',
        address_error: '{{ $data['address_error'] }}'
    };
</script>
<script src="{{ asset('js/jquery-ui.js') }}" defer></script>
<script src="{{ asset('js/main.js') }}" defer></script>
    @if(!(Request::is('inbox/*') || Request::is('inbox')))
        {!! $setting::getSettingValue('google_analytics_code') !!}
    @endif
@endsection

@section('content')
<div class="">
    <div class="row justify-content-center no-margin" style="width:100%">
        <div class="col-md-12 no-padding">
            <div class="card no-border">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xl-12 mx-auto">
                            <div class="row text-center">
                                {!! $ad::getCode(1) !!}
                            </div>
                            <div class="row">
                                <div class="col-md-11 col-lg-10 col-sm-12 col-xl-8 mx-auto">
                                    <h3 class="text-center">Welcome to {{ config('app.name') }}</h3>
                                    <h5 class="text-center py-2">Write your own username or generate random usernames.<br />You can also select or search domain from available domain names.</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11 col-lg-10 col-sm-12 col-xl-8 mx-auto">
                                    <div class="username-domain-box text-center">
                                        <div class="input-group input-group-lg mb-3">
                                            <div class="input-group-prepend" id="msg-icon-div">
                                                <span class="input-group-text message-icon"><i class="far fa-envelope"></i></span>
                                            </div>
                                            <input type="text" id="username" style="border-right:0px;padding-right:0;" class="form-control form-control-no-border text-right" v-on:blur="username=$event.target.value" v-on:keyup.enter="username=$event.target.value" v-bind:value="username" value="{{ $data['user']->username }}">
                                            <div class="input-group-append">
                                                <span class="at-sign input-group-text">@</i></span>
                                            </div>
                                            <input type="text" style="border-left:0px;border-right:0px;padding-left:0;" class="form-control form-control-no-border text-left" id="domain-name" v-on:blur="domain=$event.target.value" v-on:keyup.enter="domain=$event.target.value" v-bind:value="domain" value="{{ $data['user']->domain->name }}">
                                            <div class="input-group-append domains-dropdown">
                                                <button class="btn btn-secondary dropdown-toggle domains-button" type="button" id="dropdownMenuButton" data-flip="false" aria-haspopup="true" aria-expanded="false">
                                                    Domains
                                                </button>
                                                <div class="dropdown-menu left-auto" aria-labelledby="dropdownMenuButton">
                                                    @foreach($data['domain']::inRandomOrder()->take(10)->get() as $domain)
                                                        <a class="dropdown-item" @click.prevent="domain='{{ $domain->name }}'">{{ $domain->name }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11 col-lg-10 col-sm-12 col-xl-8 text-center mx-auto">
                                    <a class="text-danger h4" v-text="address_error"></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11 col-lg-10 col-sm-12 col-xl-8 text-center mx-auto">
                                    <span class="email-text">Your email address is <a class="text-primary pointer" v-text="email" @click="copyEmail()">{{ $data['user']->email }}</a></span>
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-md-11 col-lg-10 col-sm-12 col-xl-8 text-center mx-auto">
                                    <span class="badge badge-secondary inbox-size-text">Inbox size : <a v-text="inbox_size">{{ $data['user']->inbox_size }}</a></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11 col-lg-10 col-sm-12 col-xl-8 text-center mx-auto random-refresh-buttons">
                                    <a href="random"><button type="button" class="btn btn-success">Generate random address</button></a>
                                    <button type="button" class="btn btn-success" @click="refreshPage()">Refresh</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11 col-lg-10 col-sm-12 col-xl-8 text-center mx-auto py-3">
                                    <a style="font-size: 18px;">This page is live and you will get email instantly.</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 no-padding">
            <div class="card no-border">
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mx-auto">
                            @if(Request::is('inbox/*') || Request::is('inbox'))
                                <div class="inbox">
                                    <div class="row inbox-header text-white bg-dark pb-2 pt-2 mr-0 ml-0">
                                        <div class="col-md-3 inbox-col">
                                            Date
                                        </div>
                                        <div class="col-md-3 inbox-col">
                                            From
                                        </div>
                                        <div class="col-md-3 inbox-col">
                                            Subject
                                        </div>
                                        <div class="col-md-3 inbox-col">
                                            Actions
                                        </div>
                                    </div>
                                    @foreach($data['user']->mails()->orderBy('created_at', 'desc')->get() as $mail)
                                        <div class="inbox-mail">
                                            <div class="row inbox-mail-header mr-0 ml-0" @click="openMail('{{$mail->file_name}}')" @if(isset($data['file_name']) && $data['file_name'] == $mail->file_name) style="border-left: 0.1rem solid green;border-right: 0.1rem solid green;border-top: 0.1rem solid green;" @endif>
                                                <div class="col-md-3 py-1">
                                                    <a>{{ $mail->created_at }}</a>
                                                </div>
                                                <div class="col-md-3 py-1">
                                                    <a class="mt-1 mb-1">@if(empty($mail->froms[0]->display)) {{$mail->froms[0]->address}} @else {{$mail->froms[0]->display}} @endif</a>
                                                </div>
                                                <div class="col-md-3 py-1">
                                                    <a class="mt-1 mb-1">{{ $mail->subject }}</a>
                                                </div>
                                                <div class="col-md-3 py-1">
                                                    <a class="" href="/inbox/download/mail/{{ $mail->file_name }}"><i class="fas fa-2x fa-file-download"></i>&nbsp;</a>
                                                    <a class="text-danger" href="/inbox/delete/mail/{{ $mail->file_name }}"><i class="fas fa-2x fa-trash"></i></a>
                                                </div>
                                            </div>
                                            @if(isset($data['file_name']) && $data['file_name'] == $mail->file_name)
                                                <div class="row mr-0 ml-0" style="background-color:#ebebeb;padding-top: 20px;border-left: 0.1rem solid green;border-right: 0.1rem solid green;border-bottom: 0.1rem solid green;">
                                                    <div class="mail-headers col-12 mx-auto no-margin no-padding">
                                                        <table class="mht">
                                                            <tr>
                                                                <td>From:</td>
                                                                <td>{{ $mail->froms[0]->display }} < {{ $mail->froms[0]->address }} ></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Time:</td>
                                                                <td>{{ $mail->created_at }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Subject:</td>
                                                                <td>{{ $mail->subject }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="inbox-mail-body col-12 mx-auto no-margin">
                                                        {!! $mail->getMessageBody() !!}
                                                    </div>
                                                    @if(count($mail->attachments))
                                                        <div class="inbox-mail-attachments col-12">
                                                            @foreach($mail->attachments as $attachment)
                                                                <div class="inbox-mail-attachment">
                                                                    <span class="attachment-name">{{ $attachment->name }}</span>
                                                                    <span class="attachment-size">{{ $attachment->sizeText() }}</span>
                                                                    <a href="/inbox/download/attachment/{{ $mail->file_name }}/{{ $attachment->name }}"><i class="fas fa-1x fa-file-download"></i></a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                @section('meta')
                                    <meta name="description" content="Send or receive temporary mails without registration. You can use your own domain to receive mails without limits.">
                                    <meta name="keywords" content="temporary email generator, temporary email, temp email, temporary mail generator, email generator, temporary mail, temp mail">
                                @endsection
                                <div class="benefits">
                                    <h3>Why Use {{ config('app.name', 'Laravel') }}?</h3>
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-4 benefit">
                                            <i class="fas fa-circle benefit-dot"></i> <a>Avoid spam emails</a>
                                        </div>
                                        <div class="col-md-4 benefit">
                                            <i class="fas fa-circle benefit-dot"></i> <a>Hide your real email</a>
                                        </div>
                                        <div class="col-md-4 benefit">
                                            <i class="fas fa-circle benefit-dot"></i> <a>Stay anonymous</a>
                                        </div>
                                        <div class="col-md-4 benefit">
                                            <i class="fas fa-circle benefit-dot"></i> <a>Signup on untrusted sites</a>
                                        </div>
                                        <div class="col-md-4 benefit">
                                            <i class="fas fa-circle benefit-dot"></i> <a>Multiple trial periods on sites</a>
                                        </div>
                                        <div class="col-md-4 benefit">
                                            <i class="fas fa-circle benefit-dot"></i> <a>User your own domain</a>
                                        </div>
                                        <div class="col-md-4 benefit">
                                            <i class="fas fa-circle benefit-dot"></i> <a>Download important mails</a>
                                        </div>
                                        <div class="col-md-4 benefit">
                                            <i class="fas fa-circle benefit-dot"></i> <a>Supports attachments</a>
                                        </div>
                                        <div class="col-md-4 benefit">
                                            <i class="fas fa-circle benefit-dot"></i> <a>Use without limits</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
