@extends('layouts.app')

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
                    <h3 class="text-center">Contact Us</h3>
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="">Submit below form to contact us for your problem or feedback</h5>
                            @if(Session::has('success'))
                                <div class="alert bg-success text-white">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            @if(Session::has('error'))
                                <div class="alert bg-danger text-white">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="row">
                                        <div class="alert alert-danger" style="margin-left:15px;margin-right:15px;">
                                            {{ $error }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <form action="{{ action('SupportController@newSupportRequest') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Your name:</label>
                                    <input type="text" name="name" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label for="">Your email:</label>
                                    <input type="email" name="email" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label for="">Message:</label>
                                    <textarea name="message" rows="8" cols="80" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
