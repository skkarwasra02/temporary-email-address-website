@extends('layouts.app')

@section('title')
<title>Compose mail | {{ config('app.name', 'Temporary Address') }}</title>
@endsection

@section('meta')
<meta name="description" content="Send mails with attachments using temporary email address">
<meta name="keywords" content="temporary email generator, temporary email, temporary mail generator, email generator, temporary mail, temp mail, send temp mails, send temporary emails">
@endsection

@section('css')
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script type="text/javascript">
    var data = {
        email : '{{ $data['user']->email }}',
        compose_token : '{{ $data['compose_token'] }}'
    };
</script>
<script src="{{ asset('js/compose.js') }}" defer></script>
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
                            <div class="row">
                                <div class="col-md-11 col-lg-10 col-sm-12 col-xl-8 mx-auto">
                                    <h3 class="text-center">Compose Mail</h3>
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
                                            <input type="text" id="username" style="border-right:0px;padding-right:0;" class="form-control form-control-no-border text-right" v-on:blur="username=$event.target.value" v-on:keyup.enter="username=$event.target.value" v-bind:value="username" value="">
                                            <div class="input-group-append">
                                                <span class="at-sign input-group-text">@</i></span>
                                            </div>
                                            <input type="text" style="border-left:0px;border-right:0px;padding-left:0;" class="form-control form-control-no-border text-left" id="domain-name" v-on:blur="domain=$event.target.value" v-on:keyup.enter="domain=$event.target.value" v-bind:value="domain" value="">
                                            <div class="input-group-append domains-dropdown">
                                                <button class="btn btn-secondary dropdown-toggle domains-button" type="button" id="dropdownMenuButton" data-flip="false" aria-haspopup="true" aria-expanded="false">
                                                    Domains
                                                </button>
                                                <div class="dropdown-menu left-auto" aria-labelledby="dropdownMenuButton">
                                                    @foreach($data['domain']::where('type', 'send')->orWhere('type', 'send_receive')->inRandomOrder()->take(10)->get() as $domain)
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
                                    <span class="email-text">Your email address is <a class="text-primary pointer" v-text="email" @click="copyEmail()"></a></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11 col-lg-10 col-sm-12 col-xl-8 text-center mx-auto random-refresh-buttons">
                                    <a href=""><button type="button" class="btn btn-success">Generate random address</button></a>
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
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 mr-auto">
                            <form action="{{ action('ComposeController@send') }}" method="post" enctype="multipart/form-data">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="list-group">
                                            @foreach ($errors->all() as $error)
                                                <li class="list-item" style="list-style-type:none;">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @csrf
                                <input type="hidden" name="compose_token" value="{{ $data['compose_token'] }}">
                                <input type="hidden" v-bind:value="email" name="from" value="">
                                <div class="form-group">
                                    <label for="to">To :</label>
                                    <input type="email" id="to" class="form-control" name="to" value="">
                                </div>
                                <div class="form-group">
                                    <label for="subject">Subject :</label>
                                    <input type="text" id="subject" class="form-control" name="subject" value="">
                                </div>
                                <div class="form-group">
                                    <label for="message">Message :</label>
                                    <textarea name="message" id="message" class="form-control" rows="8" cols="80"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="attachment">Attachments :</label>
                                    <input type="file" name="attachment" id="attachment" @change="uploadFile($event)" value="">
                                </div>
                                <div class="form-group">
                                    <ul class="list-group" id="uploads-status" style="display:none;">
                                        <li class="list-group-item" v-bind:class="{'bg-primary text-white':(status.percentage == 100)}" v-for="status in uploading_status" style="list-style-type:none;">
                                            <span v-if="status.percentage == 100"><span v-text="status.filename"></span> Uploaded</span>
                                            <span v-if="status.percentage < 100"><span v-text="status.filename"></span> Uploaded  <span v-text="status.percentage"></span>%</span>
                                            <span @click="status.cancelAttachment()"><i class="fas fa-times"></i></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success" value="Send">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
