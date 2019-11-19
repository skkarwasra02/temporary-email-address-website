@extends('layouts.app')

@section('title')
<title>Terms of service | {{ config('app.name', 'Temporary Address') }}</title>
@endsection

@section('css')
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
@endsection

@section('scripts')
@endsection

@section('content')
<div class="">
    <div class="row justify-content-center no-margin" style="width:100%;">
        <div class="col-12 no-padding">
            <div class="card no-border">
                <div class="card-body">
                    <h3 class="text-center">Terms of service</h3>
                    <div class="row">
                        <div class="col-md-9">
                            <h5>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service.</h5><br />

                            <ul>
                                <li>You are not allowed to attack this website for getting access to protected pages.</li>
                                <li>You can not use this service to harm someone.</li>
                                <li>You are not allowed to over use this website by sending repeatedly request to our server.</li>
                                <li>We are not responsible for what you receive in your email address. Please check that carefully.</li>
                            </ul><br />

                            <h4>Terms for sending mail</h4>
                            <ul>
                                <li>You are not allowed to send spam mail.</li>
                                <li>You are not allowed to send illegal message.</li>
                                <li>You are not allowed to abuse, harm email receiver</li>
                            </ul><br />

                            <h4>Links To Other Web Sites</h4>
                            <p>
                                Our Service may contain links to third-party web sites or services that are not owned or controlled by Temporary Email Address.

                                Temporary Email Address has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party web sites or services. You further acknowledge and agree that Temporary Email Address shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such web sites or services.

                                We strongly advise you to read the terms and conditions and privacy policies of any third-party web sites or services that you visit.
                            </p><br />

                            <h4>Changes</h4>
                            <p>
                                We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will try to provide at least 30 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.

                                By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.
                            </p><br />

                            <h4>Contact Us</h4>
                            <a>If you have any questions about these Terms, please contact us.</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
