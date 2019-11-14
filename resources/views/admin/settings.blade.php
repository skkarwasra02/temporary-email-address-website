@extends('admin.layouts.app')

@section('js')
@endsection

@section('css')
<style>
.settings-form label {
    font-size: 18px;
}
.settings-form .input-group-lg input {
    font-size: 22px;
}
</style>
@endsection

@section('content')

@if(session('success'))
<div class="row mx-auto">
    <div class="alert alert-success" style="margin-left:15px;margin-right:15px;">
        {{ session('success') }}
    </div>
</div>
@endif
<div class="row mx-auto">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <span class="h3">Settings</span>
            </div>
            <div class="card-body">
                <form class="settings-form form" action="{{ action('Admin\SettingsController@saveSettings') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="" for="random_username_characters">Random Username Characters :</label>
                                <input type="text" id="random_username_characters" class="form-control-lg" name="settings[random_username_characters]" value="{{ $data['settings']::getSettingValue('random_username_characters') }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="" for="random_username_length">Random Username Length :</label>
                                <input type="text" id="random_username_length" class="form-control-lg" name="settings[random_username_length]" value="{{ $data['settings']::getSettingValue('random_username_length') }}">
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info h5">
                                Note: Mail server is required to automatically check for new domains on server.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="" for="mail_server">Mail Server :</label>
                                <input type="text" id="mail_server" class="form-control-lg" name="settings[mail_server]" value="{{ $data['settings']::getSettingValue('mail_server') }}">
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="" for="security_key">Security Key :</label>
                                <input type="text" id="security_key" class="form-control-lg" name="settings[security_key]" value="{{ $data['settings']::getSettingValue('security_key') }}">
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-12">
                            <div class="h5">
                                Cron Job Action's Setting
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="" for="delete_attachments">Delete Attachments(Hours) :</label>
                                <input type="text" id="delete_attachments" class="form-control-lg" name="settings[delete_attachments]" value="{{ $data['settings']::getSettingValue('delete_attachments') }}">
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="" for="google_analytics_code">Google Analytics Code :</label>
                                <textarea id="google_analytics_code" class="form-control-lg" name="settings[google_analytics_code]" rows="8" cols="80">{{ $data['settings']::getSettingValue('google_analytics_code') }}</textarea>
                            </div>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-6 mx-auto">
                            <button type="submit" class="btn col btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
