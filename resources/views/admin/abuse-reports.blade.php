@extends('admin.layouts.app')

@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
<script src="{{ asset('js/admin/abusereports.js') }}" defer></script>
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
@if(!isset($data['view-reports']))
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
                        <button class="btn btn-primary">Get Reports</button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="row mx-auto">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <span class="h3">Abuse Reports</span>
                    </div>
                    <div class="card-body">
                        <table class="dataTable text-center" id="reportsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Time</th>
                                    <th>By</th>
                                    <th>For</th>
                                    <th>For Mail ID</th>
                                    <th>Block All</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['abuse_reports'] as $report)
                                    <tr>
                                        <td>{{ $report->id }}</td>
                                        <td><time class="timeago" datetime="{{ $report->created_at }}"></time></td>
                                        <td>{{ $report->sentMail->to }}</td>
                                        <td>{{ $report->sentMail->from }}</td>
                                        <td>{{ $report->sentMail->id }}</td>
                                        <td>{{ $report->block_all }}</td>
                                        <td>
                                            <button class="btn btn-secondary" onclick="showMessage('{{ $report->message }}')">View Message</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="showMessageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea class="form-control" id="message" rows="10" cols="80"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
<script type="text/javascript" defer>
function showMessage(message) {
    $("#message").val(message);
    $("#showMessageModal").modal('show');
}
</script>
@endsection
