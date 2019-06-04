@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        <div class="page-content fade-in-up">
            <div class="row mb-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4">
                        <div class="card-body flexbox-b">
                            <div class="easypie mr-4" data-percent="@if($return['total_projects'] > 0){{$return['completed_projects']*100/$return['total_projects']}}@endif" data-bar-color="#5c6bc0" data-size="80" data-line-width="8">
                                <span class="easypie-data font-26 text-primary"><i class="ti-book"></i></span>
                            </div>
                            <div>
                                <h3 class="font-strong text-primary">{{$return['total_projects']}}</h3>
                                <div class="text-muted">TOTAL PROJECTS</div>
                            </div>                            
                            <div class="ml-5">
                                <h3 class="font-strong text-primary">{{$return['completed_projects']}}</h3>
                                <div class="text-muted">COMPLETED PROJECTS</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4">
                        <div class="card-body flexbox-b">
                            <div class="easypie mr-4" data-percent="@if($return['total_requests'] > 0){{$return['approved_requests']*100/$return['total_requests']}}@endif" data-bar-color="#ff4081" data-size="80" data-line-width="8">
                                <span class="easypie-data text-pink" style="font-size:32px;"><i class="ti-help"></i></span>
                            </div>
                            <div>
                                <h3 class="font-strong text-pink">{{$return['total_requests']}}</h3>
                                <div class="text-muted">TOTAL REQUESTS</div>
                            </div>
                            <div class="ml-5">
                                <h3 class="font-strong text-pink">{{$return['approved_requests']}}</h3>
                                <div class="text-muted">APPRPVED REQUESTS</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4">
                        <div class="card-body flexbox-b">
                            <div class="easypie mr-4" data-percent="@if($return['total_requested_money'] > 0){{$return['total_approved_money']*100/$return['total_requested_money']}}@endif" data-bar-color="#18C5A9" data-size="80" data-line-width="8">
                                <span class="easypie-data text-success" style="font-size:32px;"><i class="la la-money"></i></span>
                            </div>
                            <div>
                                <h3 class="font-strong text-success">{{$return['total_requested_money']}}</h3>
                                <div class="text-muted">REQUESTED MONEY</div>
                            </div>
                            <div class="ml-5">
                                <h3 class="font-strong text-success">{{$return['total_approved_money']}}</h3>
                                <div class="text-muted">APPROVED MONEY</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
        @include('layouts.footer')
    </div>
@endsection

@section('script')
    <!-- PAGE LEVEL PLUGINS-->
    <script src="{{ asset('master/vendors/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('master/vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('master/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('master/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <script src="{{ asset('master/js/scripts/dashboard_visitors.js') }}"></script>
@endsection