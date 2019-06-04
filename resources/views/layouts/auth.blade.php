<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name')}}</title>
        <!-- Main CSS-->
        <link rel="stylesheet" href="{{ asset('master/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/themify-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/animate.css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/toastr/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('master/css/main.css') }}">
        @yield('stylesheet')
    </head>
    <body>
        <div class="cover"></div>

        @yield('content')

        <!-- BEGIN PAGA BACKDROPS-->
        <div class="sidenav-backdrop backdrop"></div>
        <div class="preloader-backdrop">
            <div class="page-preloader">Loading</div>
        </div>
        <!-- CORE PLUGINS-->
        <script src="{{ asset('master/vendors/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('master/vendors/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('master/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('master/vendors/metisMenu/dist/metisMenu.min.js') }}"></script>
        <script src="{{ asset('master/vendors/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('master/vendors/jquery-idletimer/dist/idle-timer.min.js') }}"></script>
        <script src="{{ asset('master/vendors/toastr/toastr.min.js') }}"></script>
        <script src="{{ asset('master/vendors/jquery-validation/dist/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('master/vendors/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

        <!-- CORE SCRIPTS-->
        <script src="{{ asset('master/js/app.min.js') }}"></script>

        @yield('script')
        
    </body>
</html>