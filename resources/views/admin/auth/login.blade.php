<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.assets.inc.head')
</head>
<body>
    <div id="" class="">
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header text-center h2">{{ __('Admin Login') }}</div>

                            <div class="card-body">
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="row">
                                            <div class="alert alert-danger mx-auto" style="margin-left:15px;margin-right:15px;">
                                                {{ $error }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @if(session('success'))
                                <div class="row">
                                    <div class="alert alert-success mx-auto" style="margin-left:15px;margin-right:15px;">
                                        {{ session('success') }}
                                    </div>
                                </div>
                                @endif
                                @if(session('error'))
                                <div class="row">
                                    <div class="alert alert-danger mx-auto" style="margin-left:15px;margin-right:15px;">
                                        {{ session('error') }}
                                    </div>
                                </div>
                                @endif
                                <form method="POST" action="{{ action('Auth\LoginController@adminLogin') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="" required>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 offset-md-4">
                                            <a href="{{ url('/admin/reset') }}">Forgot password</a>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
