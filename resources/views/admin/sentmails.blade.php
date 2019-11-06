@extends('admin.layouts.app')

@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
<script src="{{ asset('js/admin/sentmails.js') }}" defer></script>
@endsection

@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
<style>
.mail-data div {
    margin-bottom: 6px;
    font-size: 17px;
}
.mail-info-label {
    font-size: 18px;
    color: blue;
}
#message-body {
    border: 1px double black;
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
@if(!isset($data['view-mail']))
    @if(!isset($data['has-limits']))
    <div class="row mx-auto">
        <div class="col-3">
            <form class="" action="" method="get">
                <div class="form-group">
                    <label for="">Start date:</label>
                    <input type="text" id="start-date" class="form-control datepicker" name="start_date" value="">
                </div>
                <div class="form-group">
                    <label for="">End date:</label>
                    <input type="text" id="end-date" class="form-control datepicker" name="end_date" value="">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Get Mails</button>
                </div>
            </form>
        </div>
    </div>
    @else
        <div class="row mx-auto">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <span class="h3">All Mails</span>
                    </div>
                    <div class="card-body">
                        <table class="dataTable text-center" id="mailsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Time</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>IP</th>
                                    <th>Report Key</th>
                                    <th>Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['sent_mails'] as $mail)
                                    <tr>
                                        <td>{{ $mail->id }}</td>
                                        <td><time class="timeago" datetime="{{ $mail->created_at }}"></time></td>
                                        <td>{{ $mail->from }}</td>
                                        <td>{{ $mail->to }}</td>
                                        <td>{{ $mail->ip }}</td>
                                        <td>{{ $mail->report_key }}</td>
                                        <td>{{ $mail->size }} bytes</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
@endsection
