@extends('layouts.auth')


@section('stylesheet')
    <!-- PAGE LEVEL STYLES-->
    <style>
        body {
            background-repeat: no-repeat;
            background-size: cover;
            background-image: url("{{ asset('master/img/blog/18.jpeg') }}");
            
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
        <form class="ibox-body" id="login-form" action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <h4 class="font-strong text-center mb-5">{{ __('Reset Password') }}</h4>
            <div class="form-group mb-4">
                <input class="form-control form-control-line" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autocomplete="email" autofocus />
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <input class="form-control form-control-line" type="password" name="password" placeholder="{{ __('Password') }}" required autocomplete="current-password" />
                @error('password')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <input class="form-control form-control-line" type="password" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required />
            </div>

            <div class="text-center mb-4">
                <button type="submit" class="btn btn-primary btn-rounded btn-block">{{ __('Reset Password') }}</button>
            </div>
        </form>
    </div>
@endsection
