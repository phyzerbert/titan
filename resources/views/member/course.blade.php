@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" />    
    <link href="{{asset('master/vendors/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
    @php
        $role = Auth::user()->role->slug;
    @endphp
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        <div class="page-heading">
            <h1 class="page-title">My Courses</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="la la-home font-20"></i></a></li>
                <li class="breadcrumb-item">Mycourses</li>
            </ol>
        </div>
        <div class="page-content fade-in-up">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="ibox">
                        <div class="ibox-body">
                            <div>
                                <h3 class="float-left mb-1">My Courses</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="coursesTable">
                                    <thead class="thead-default thead-lg">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Task</th>
                                            <th>Status</th>
                                            <th>Project</th>
                                            <th>Completion</th>
                                            <th>Due Date</th>
                                            <th>Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courses as $item)
                                            <tr>
                                                <td class="text-center">{{ (($courses->currentPage() - 1 ) * $courses->perPage() ) + $loop->iteration }}</td>
                                                <td class="name">{{$item->name}}</td>
                                                <td class="status" data-value="{{$item->status}}">
                                                    @if ($item->status == 1)
                                                        <span class="badge badge-primary badge-pill">New</span>
                                                    @elseif ($item->status == 2)
                                                        <span class="badge badge-secondary badge-pill">In Progress</span>
                                                    @elseif ($item->status == 3)
                                                        <span class="badge badge-info badge-pill">On Hold</span>
                                                    @elseif ($item->status == 4)
                                                        <span class="badge badge-success badge-pill">Completed</span>
                                                    @endif
                                                </td>
                                                <td class="project" data-value="{{$item->project_id}}">@isset($item->project->name){{$item->project->name}}@endisset</td>
                                                <td class="prog" data-value="{{$item->progress}}">{{$item->progress}}%</td>
                                                <td class="due_to">{{$item->due_to}}</td>
                                                <td class="created_at">{{$item->created_at}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody> 
                                </table>                                   
                                <div class="clearfix">
                                    <div class="float-left" style="margin: 0;">
                                        <p>Total <strong style="color: red">{{ $courses->total() }}</strong> Courses</p>
                                    </div>
                                    <div class="float-right" style="margin: 0;">
                                        {!! $courses->appends([])->links() !!}
                                    </div>
                                </div>
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

    <script src="{{asset('master/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('master/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>    
    <script src="{{asset('master/vendors/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script>
        $(document).ready(function(){

        });
    </script>
@endsection