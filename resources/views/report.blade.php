@extends('layouts.app')

@section('title')
<title>Report | {{ config('app.name', 'Temporary Address') }}</title>
@endsection

@section('css')
<link href="{{ asset('css/main.css') }}" rel="stylesheet">
@endsection

@section('scripts')
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
                                    <h3 class="text-center">Report</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11 col-lg-10 col-sm-12 col-xl-8">
                                    <form class="" action="" method="post">
                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        @csrf
                                        <input type="hidden" name="report_key" value="{{ app('request')->r }}">
                                        <div class="form-group">
                                            <label>From: {{ $data['from'] }}</label>
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Message: </label>
                                            <textarea name="message" id="message" class="form-control" rows="8" cols="80"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="block_all" value="yes"> Block everyone from sending mails to you
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
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
