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

        .register-content {
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
    <div class="ibox register-content">
        <div class="text-center">
            <span class="auth-head-icon"><i class="la la-user"></i></span>
        </div>
        <form class="ibox-body" id="register-form" action="{{ route('register') }}" method="POST">
            @csrf
            <h4 class="font-strong text-center mb-5">SIGN UP</h4>
            <div class="form-group mb-4">
                <input class="form-control form-control-line" type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('Name') }}" required autocomplete="name" autofocus />
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-4">
                <input class="form-control form-control-line" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autocomplete="email"/>
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
            <div class="form-group mb-4">
                <input class="form-control form-control-line" type="password" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required />
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="text-center mb-4">
                <button type="submit" class="btn btn-primary btn-rounded btn-block">SIGN UP</button>
            </div>
            <p class="text-center">Do you have an account already? <a href="{{route('login')}}">Sign In</a></p>
        </form>
    </div>
@endsection

@section('after-js')
    <script>
        $(function() {
            $('#register-form').validate({
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
