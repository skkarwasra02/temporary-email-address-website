@extends('admin.layouts.app')

@section('js')
<script src="{{ asset('js/admin/accounts.js') }}" defer></script>
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
<div class="row mx-auto">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <span class="h3">Accounts</span>
            </div>
            <div class="card-body">
                <table class="dataTable text-center" id="accountsTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Created At</th>
                            <th>Email</th>
                            <th>Last Login</th>
                            <th>Mails</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['accounts'] as $user)
                            <tr data-account-id="{{ $user->user_id }}">
                                <td>{{ $user->user_id }}</td>
                                <td><time class='timeago' datetime="{{ $user->created_at->format('c') }}"></time></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->last_login }}</td>
                                <td>{{ $user->inbox_size }}</td>
                                <td>
                                    <a href="{{ url('/admin/accounts/delete/account/id/' . $user->user_id) }}" onclick="return confirm('All mails related to this account will deleted. Are you sure?')" data-toggle='tooltip' data-placement='bottom' title='Delete'><i class="fas fa-trash fa-2x text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
