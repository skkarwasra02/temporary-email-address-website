<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.assets.inc.head')
</head>
<body>
    <div id="" class="">
        <main class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card">
                            <div class="card-header text-center h2">{{ __('Admin Password Reset') }}</div>

                            <div class="card-body">
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="row">
                                            <div class="alert alert-danger" style="margin-left:15px;margin-right:15px;">
                                                {{ $error }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @if(session('success'))
                                <div class="row">
                                    <div class="alert alert-success" style="margin-left:15px;margin-right:15px;">
                                        {{ session('success') }}
                                    </div>
                                </div>
                                @endif
                                @if(session('error'))
                                <div class="row">
                                    <div class="alert alert-danger" style="margin-left:15px;margin-right:15px;">
                                        {{ session('error') }}
                                    </div>
                                </div>
                                @endif
                                <form method="POST" action="">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Admin Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="dbpassword">Database Password</label>
                                        <input type="password" class="form-control" id="dbpassword" name="dbpassword" required />
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success">Reset</button>
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
