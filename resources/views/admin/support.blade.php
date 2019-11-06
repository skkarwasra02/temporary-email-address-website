@extends('admin.layouts.app')

@section('js')
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
@endsection

@section('content')

@if(session('success'))
<div class="row mx-auto">
    <div class="alert alert-success" style="margin-left:15px;margin-right:15px;">
        {{ session('success') }}
    </div>
</div>
@endif
@if(session('error'))
<div class="row mx-auto">
    <div class="alert alert-danger" style="margin-left:15px;margin-right:15px;">
        {{ session('error') }}
    </div>
</div>
@endif
<div class="row mx-auto">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <span class="h3">Support Requests</span>
            </div>
            <div class="card-body">
                <table class="dataTable text-center" id="supportTable">
                    <thead>
                        <tr>
                            <th>Support ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th style="display:none;">Message</th>
                            <th>Resolved</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['supports'] as $support)
                            <tr>
                                <td>{{ $support->id }}</td>
                                <td>{{ $support->name }}</td>
                                <td>{{ $support->email }}</td>
                                <td style="display:none;"><textarea id="support_message_{{ $support->id }}">{{ $support->message }}</textarea></td>
                                <td>{{ $support->resolved }}</td>
                                <td>
                                    <a onclick="showMessage({{$support->id}})" data-toggle='tooltip' data-placement='bottom' title='View'><i class="fas fa-eye fa-2x text-primary"></i></a>
                                    <a href="{{ url('/admin/support/resolve/' . $support->id . '/' . (($support->resolved == 'yes') ? 'no' : 'yes')) }}" data-toggle='tooltip' data-placement='bottom' title='Change resolved status'><i class="fas fa-{{(($support->resolved == 'yes') ? 'times' : 'check')}} fa-2x text-{{(($support->resolved == 'yes') ? 'danger' : 'warning')}}"></i></a>
                                    <a href="{{ url('/admin/support/delete/' . $support->id) }}" data-toggle='tooltip' data-placement='bottom' title='Delete'><i class="fas fa-trash fa-2x text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Message Modal -->
<div class="modal fade" id="message-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="message-modal-heading"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea class="form-control" cols="50" rows="10" id="message"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function showMessage(id) {
        $("#message-modal-heading").html("Message of Support ID " + id);
        $("#message").val($("#support_message_" + id).val());
        $("#message-modal").modal('show');
    }
</script>
@endsection
