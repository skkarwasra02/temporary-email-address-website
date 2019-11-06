@extends('admin.layouts.app')

@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
<script src="{{ asset('js/admin/mails.js') }}" defer></script>
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
                        <span class="h3">Mails</span>
                    </div>
                    <div class="card-body">
                        <table class="dataTable text-center" id="mailsTable">
                            <thead>
                                <tr>
                                    <th>Mail ID</th>
                                    <th>Time</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Subject</th>
                                    <th><i class="fas fa-paperclip"></i></th>
                                    <th>Filename</th>
                                    <th>Size</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['mails'] as $mail)
                                    <tr>
                                        <td>{{ $mail->mail_id }}</td>
                                        <td><time class="timeago" datetime="{{ $mail->created_at }}"></time></td>
                                        <td>{{ $mail->froms[0]->display }}</td>
                                        <td>{{ $mail->tos[0]->display }}</td>
                                        <td>{{ $mail->subject }}</td>
                                        <td>{{ $mail->attachments->count() }}</td>
                                        <td>{{ $mail->file_name }}</td>
                                        <td>{{ $mail->size }} bytes</td>
                                        <td>
                                            <a href="{{ url('/admin/mails/view/id/' . $mail->mail_id) }}" data-toggle='tooltip' data-placement='bottom' title='View'><i class="fas fa-eye fa-2x text-primary"></i></a>
                                            <a href="{{ url('/admin/mails/delete/id/' . $mail->mail_id) }}" onclick="return confirm('Are you sure?')" data-toggle='tooltip' data-placement='bottom' title='Delete'><i class="fas fa-trash fa-2x text-danger"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@else
<div class="row mx-auto">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <span class="h3">View Mail ID {{ $data['mail-id'] }}</span>
            </div>
            <div class="card-body mail-data">
                <div class="row">
                    <div class="col-12 mail-from">
                        <span class="mail-info-label">From:</span> {{ $data['mail']['from'] }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mail-to">
                        <span class="mail-info-label">To:</span> {{ $data['mail']['to'] }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mail-created-at">
                        <span class="mail-info-label">Time:</span> <time class="timeago" datetime="{{ $data['mail']['created_at'] }}"></time>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mail-subject">
                        <span class="mail-info-label">Subject:</span> {{ $data['mail']['subject'] }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mail-attachments">
                        <span class="mail-info-label">Attachments:</span> <br />
                        @foreach($data['mail']['attachments'] as $attachment)
                            <span><a href="{{ url('/admin/mails/download/attachment/id/' . $attachment->attachment_id) }}" target="_blank">{{ $attachment->name }}</a></span>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="mail-info-label">Body:</span>
                    </div>
                    <div class="col-12" id="message-body">
                        {!! ($data['mail']['message_body']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

</script>
@endif
@endsection
