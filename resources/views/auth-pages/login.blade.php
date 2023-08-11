@extends('auth-pages.base-auth')
@section("main-content")
    <body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/user/login"><b>Buddies</b>LTE</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="/user/login" method="post">
                    @error("error")
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Error</h5>
                            Username and password do not match.Try again
                    </div>
                    @enderror
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control @error("username") is-invalid @enderror" placeholder="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>

                    </div>
                    @error("username")
                    <div class="card card-danger mb-3 mt-3">
                        <div class="card-header">
                            <h5 class="card-title">
                                username required
                            </h5>
                        </div>
                    </div>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="password" name="password" value="{{ old("password") }}" class="form-control
                        @error("password") is-invalid @enderror
                        " placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @error("password")
                        <div class="card card-danger mb-3">
                            <div class="card-header">
                                <h5 class="card-title">
                                    Password required
                                </h5>
                            </div>
                        </div>
                    @enderror
                    <div class="row">
{{--                        <div class="col-8">--}}
{{--                            <div class="icheck-primary">--}}
{{--                                <input type="checkbox" id="remember" name="su">--}}
{{--                                <label for="remember">--}}
{{--                                    Remember Me--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <!-- /.social-auth-links -->

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    </body>
@endsection()

