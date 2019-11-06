@extends('admin.layouts.app')
@section('js')
<script src="{{ asset('js/admin/dashboard.js') }}" defer></script>
@endsection
@section('content')
<div class="row mx-auto" style="width:100%">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header h3 text-center">
                Today
            </div>
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <span class="st-label float-left">Email Accounts&nbsp;&nbsp;</span>
                        <span class="st-value">{{ $data['today-email-account'] }}</span><br>
                    </div>
                    <div class="float-right">
                        <i class="fas fa-at fa-4x float-right"></i>
                    </div>
                </div>
                <div class="line"></div>
                <div class="clearfix">
                    <div class="float-left">
                        <span class="st-label float-left">Emails Received&nbsp;&nbsp;</span>
                        <span class="st-value">{{ $data['today-email-received'] }}</span><br>
                    </div>
                    <div class="float-right">
                        <i class="fas fa-envelope fa-4x float-right"></i>
                    </div>
                </div>
                <div class="line"></div>
                <div class="row" style="font-size: 19px;">
                    <div class="col-6">
                        Total Size
                    </div>
                    <div class="col-6">
                        {{ $data['today-emails-size'] }} MB
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header h3 text-center">
                Weekly
            </div>
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <span class="st-label float-left">Email Accounts&nbsp;&nbsp;</span>
                        <span class="st-value">{{ $data['weekly-email-accounts'] }}</span><br>
                    </div>
                    <div class="float-right">
                        <i class="fas fa-at fa-4x float-right"></i>
                    </div>
                </div>
                <div class="line"></div>
                <div class="clearfix">
                    <div class="float-left">
                        <span class="st-label float-left">Emails Received&nbsp;&nbsp;</span>
                        <span class="st-value">{{ $data['weekly-email-received'] }}</span><br>
                    </div>
                    <div class="float-right">
                        <i class="fas fa-envelope fa-4x float-right"></i>
                    </div>
                </div>
                <div class="line"></div>
                <div class="row" style="font-size: 19px;">
                    <div class="col-6">
                        Total Size
                    </div>
                    <div class="col-6">
                        {{ $data['weekly-emails-size'] }} MB
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header h3 text-center">
                Total
            </div>
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <span class="st-label float-left">Email Accounts&nbsp;&nbsp;</span>
                        <span class="st-value">{{ $data['total-email-accounts'] }}</span><br>
                    </div>
                    <div class="float-right">
                        <i class="fas fa-at fa-4x float-right"></i>
                    </div>
                </div>
                <div class="line"></div>
                <div class="clearfix">
                    <div class="float-left">
                        <span class="st-label float-left">Emails Received&nbsp;&nbsp;</span>
                        <span class="st-value">{{ $data['total-email-received'] }}</span><br>
                    </div>
                    <div class="float-right">
                        <i class="fas fa-envelope fa-4x float-right"></i>
                    </div>
                </div>
                <div class="line"></div>
                <div class="row" style="font-size: 19px;">
                    <div class="col-6">
                        Total Size
                    </div>
                    <div class="col-6">
                        {{ $data['total-emails-size'] }} MB
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><br>
@endsection
