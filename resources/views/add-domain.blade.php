@extends('layouts.app')

@section('meta')
<meta name="description" content="Add your own domain to receive mails for free">
@endsection

@section('css')
@endsection

@section('scripts')
@endsection

@section('content')
<div class="">
    <div class="row justify-content-center no-margin" style="width:100%;">
        <div class="col-12 no-padding">
            <div class="card no-border">
                <div class="card-body">
                    <h3 class="text-center">Add domain</h3>
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <h5 class="">Add your own domain name to {{config('app.name')}}</h5>
                            <ul class="list-group add-domain-steps">
                                <li class="list-group-item">Step 1. Buy your domain name from domain registration website, if you already haven't bought.</li>
                                <li class="list-group-item">
                                    Step 2. Login to your account and set up DNS MX records.
                                    <ul>
                                        <li>
                                            Host: Give name of your domain
                                        </li>
                                        <li>
                                            Record Type: MX Record
                                        </li>
                                        <li>
                                            Priority: 1
                                        </li>
                                        <li>
                                            Mail Server: {{ $setting::getSettingValue('mail_server') }}
                                        </li>
                                    </ul>
                                </li>
                                <li class="list-group-item">
                                    Step 3. Wait until DNS changes take effect
                                </li>
                                <li class="list-group-item">
                                    Step 4. You can check your domain name by typing domain name in email field after @ sign on home/inbox page
                                </li>
                                <li class="list-group-item">
                                    Or contact us, We will set up your domain name
                                </li>
                            </ul><br />
                            <h3 class="">Check MX records of your domain name using below tool</h3>
                            <div class="row">
                                <div class="col-6">
                                    @if(isset($mxrecords))
                                        {{ count($mxrecords) }} MX Records Found For {{ $_POST['domain'] }}
                                        <ul class="list-group">
                                            @foreach($mxrecords as $mxrecord)
                                                <li class="list-group-item {{($mxrecord['mxhost'] == $setting::getSettingValue('mail_server')) ? 'bg-success text-white' : ''}}">
                                                    Priority: {{$mxrecord['weight']}} Host: {{ $mxrecord['mxhost']}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <form action="{{action('AddDomainController@checkMX')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Domain(without http:// or https://) : </label>
                                            <input type="text" class="form-control" name="domain" value="">
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Check">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
