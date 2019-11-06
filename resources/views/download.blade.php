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
                    <h4 class="text-center">{{ $data['title'] }}</h4>
                    <div class="row">
                        <div class="col-md-4 mx-auto text-center">
                            @foreach($data['file'] as $name => $value)
                                <div>
                                    {{ $name }} : {{ $value }}
                                </div>
                            @endforeach
                            <form class="" action="" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary">Download</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
