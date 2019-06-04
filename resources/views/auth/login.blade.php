@extends('layouts.auth')

@section('stylesheet')
    <!-- PAGE LEVEL STYLES-->
    <style>
        body {
            background-repeat: no-repeat;
            background-size: cover;
            background-image: url("{{ asset('master/img/blog/17.jpeg') }}");
            
        }

        .cover {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(117, 54, 230, .1);
        }

        .login-content {
            max-width: 400px;
            margin: 100px auto 50px;
        }

        .auth-head-icon {
            position: relative;
            height: 60px;
            width: 60px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            background-color: #fff;
            color: #5c6bc0;
            box-shadow: 0 5px 20px #d6dee4;
            border-radius: 50%;
            transform: translateY(-50%);
            z-index: 2;
        }
    </style>
@endsection
@section('content')
    <div class="ibox login-content">
        <div class="text-center">
            <span class="auth-head-icon"><i class="la la-user"></i></span>
        </div>
        <form class="ibox-body" id="login-form" action="{{ route('login') }}" method="POST">
            @csrf
            <h4 class="font-strong text-center mb-5">LOG IN</h4>
            <div class="form-group mb-4">
                <input class="form-control form-control-line" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autocomplete="email" autofocus />
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-4">
                <input class="form-control form-control-line" type="password" name="password" placeholder="{{ __('Password') }}" required autocomplete="current-password" />
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="flexbox mb-5">
                <span>
                <label class="ui-switch switch-icon mr-2 mb-0">
                    <input type="checkbox" name="remember" id="remember"  {{ old('remember') ? 'checked' : '' }} />
                    <span></span>
                </label>Remember</span>
                @if (Route::has('password.request'))
                    <a class="text-primary" href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>
            <div class="text-center mb-4">
                <button type="submit" class="btn btn-primary btn-rounded btn-block">LOG IN</button>
            </div>
            <p class="text-center">Don't have an account? <a href="/register">Sign Up</a></p>
        </form>
    </div>
@endsection

@section('after-js')
    <script>
        $(function() {
            $('#login-form').validate({
                errorClass: "help-block",
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                highlight: function(e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    $(e).closest(".form-group").removeClass("has-error")
                },
            });
        });
    </script>
@endsection