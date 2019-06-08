<!DOCTYPE html>
<html dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name')}}</title>
        <!-- Main CSS-->
        <link rel="stylesheet" href="{{ asset('master/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/themify-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/animate.css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/toastr/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('master/vendors/jvectormap/jquery-jvectormap-2.0.3.css') }}">
        <link rel="stylesheet" href="{{ asset('master/css/main.css') }}">
        @yield('style')        
    </head>
    <body class="fixed-navbar">        
        <div class="page-wrapper">

            @include('layouts.header')

            @include('layouts.aside')

            @yield('content')

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
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <script>
            var notification = '<?php echo session()->get("success"); ?>';
            if(notification != ''){
                toastr_call("success","Success",notification);
            }
            var errors_string = '<?php echo json_encode($errors->all()); ?>';
            errors_string=errors_string.replace("[","").replace("]","").replace(/\"/g,"");
            var errors = errors_string.split(",");
            if (errors_string != "") {
                for (let i = 0; i < errors.length; i++) {
                    const element = errors[i];
                    toastr_call("error","Error",element);             
                } 
            }
            
            function toastr_call(type,title,msg,override){
                toastr[type](msg, title,override);
                toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                }  
            }
        </script>
        
    </body>
</html>