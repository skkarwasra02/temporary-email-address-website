@extends('admin.layouts.app')

@section('js')
@endsection

@section('css')
<style>
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
                <span class="h3">Profile</span>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Email :</label>
                        <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}">
                    </div>
                    <div class="form-group">
                        <label for="">New Password :</label>
                        <input type="password" class="form-control" name="password" min="6" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Password :</label>
                        <input type="password" class="form-control" name="password_confirmation" min="6" value="">
                    </div>
                    <div class="form-group">
                        <label for=""><span class="text-danger">*</span>Old Password :</label>
                        <input type="password" class="form-control" name="opassword" value="" min="6" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
