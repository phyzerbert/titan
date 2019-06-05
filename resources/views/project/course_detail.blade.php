@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" />  
    <link href="{{asset('master/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <style>
        span.select2-container{width: 100% !important;}
    </style>
@endsection
@section('content')
    @php
        $role = Auth::user()->role->slug;
    @endphp
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        <div class="page-heading">
            <h1 class="page-title">Course Overview</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="la la-home font-20"></i></a></li>
                <li class="breadcrumb-item">Project</li>
                <li class="breadcrumb-item">Course Overview</li>
            </ol>
        </div>
        <div class="page-content fade-in-up">
            <div class="row">
                <div class="col-xl-10 mx-auto">
                    <div class="ibox">
                        <div class="ibox-body">
                            <div class="d-flex justify-content-between m-b-20">
                                <div>
                                    <h3 class="m-0">{{$course->name}}</h3>
                                    <div>{{$course->description}}</div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-3 pl-3">
                                    <h6 class="mb-3">Course Created</h6>
                                    <span class="h2 mr-3"><i class="fa fa-calendar text-primary h1 mb-0 mr-2"></i>
                                        <span>{{date('Y-m-d', strtotime($course->created_at))}}</span>
                                    </span>
                                </div>
                                <div class="col-3 pl-3">
                                    <h6 class="mb-3">Course Status</h6>
                                    <span class="h2 mr-3"><i class="fa fa-list text-primary h1 mb-0 mr-2"></i>
                                        <span>{{$course->status}}</span>
                                    </span>
                                </div>
                                <div class="col-3 pl-4">
                                    <h6 class="mb-3">Course Members</h6>
                                    <span class="h2 mr-3"><i class="fa fa-users text-primary h1 mb-0 mr-2"></i>
                                        <span>{{$course->members()->count()}}</span>
                                    </span>
                                </div>                              
                                <div class="col-3 pl-4">
                                    <h6 class="mb-3">Project Progress</h6>
                                    <span class="h2 mr-3"><i class="fa fa-spinner text-primary h1 mb-0 mr-2"></i>
                                        <span>{{$course->progress}}%</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-head">
                            <div class="ibox-title">COURSE TEAM</div>
                            @if ($role == 'project_manager')                                
                                <a href="#" id="btn-add-member" class="btn btn-sm btn-primary btn-fix float-right mb-2"><span class="btn-icon"><i class="ti-plus"></i>Add Member</span></a>
                            @endif
                        </div>
                        <div class="ibox-body">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;"><ul class="media-list media-list-divider mr-2 scroller">
                                @foreach ($course->members as $member)
                                    <li class="media align-items-center py-1">
                                        <a class="media-img" href="javascript:;">
                                            <img class="img-circle" src="@if (isset($member->picture)){{asset($member->picture)}} @else {{asset('images/avatar128.png')}} @endif" alt="image" width="45">
                                        </a>
                                        <div class="media-body d-flex align-items-center">
                                            <div class="flex-1">
                                                <div class="media-heading">{{$member->name}}</div><small class="text-muted"><a href="mailto:{{$member->email}}">{{$member->email}}</a></small></div>
                                            <span class="badge badge-success badge-pill">Member</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul><div class="slimScrollBar" style="background: rgb(113, 128, 143); width: 4px; position: absolute; top: 28px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 552.381px;"></div><div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.9; z-index: 90; right: 1px;"></div></div>
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-head">
                            <div class="ibox-title">REQUESTS FOR THIS COURSE</div>
                            {{-- @if ($role == 'project_manager')                                
                                <a href="#" id="btn-add-member" class="btn btn-sm btn-primary btn-fix float-right mb-2"><span class="btn-icon"><i class="ti-plus"></i>Add Member</span></a>
                            @endif --}}
                        </div>
                        <div class="ibox-body">
                            <table class="table table-bordered table-hover" id="requestsTable">
                                <thead class="thead-default thead-lg">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Project</th>
                                        <th>Course</th>
                                        <th>Amount</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Attachment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($course->requests as $item)
                                        <tr>
                                            <td class="text-center">{{$loop->iteration }}</td>
                                            <td class="title">{{$item->title}}</td>
                                            <td class="description">{{$item->description}}</td>
                                            <td class="project" data-value="{{$item->course->project->id}}">@isset($item->course->project->id){{$item->course->project->name}}@endisset</td>
                                            <td class="course" data-value="{{$item->course_id}}">@isset($item->course->name){{$item->course->name}}@endisset</td>
                                            <td class="amount">{{$item->amount}}</td>
                                            <td class="text-center py-1">
                                                @switch($item->status)
                                                    @case(0)
                                                        <span class="badge badge-primary badge-pill">Pending</span>
                                                        @break
                                                    @case(1)
                                                        <span class="badge badge-danger badge-pill">Rejected</span>
                                                        @break
                                                    @case(2)
                                                        <span class="badge badge-success badge-pill">Approved</span>
                                                        @break
                                                    @default
                                                        
                                                @endswitch
                                            </td>
                                            <td class="attachment text-center">
                                                @if($item->attachment != null)
                                                    @php
                                                        $path_info = pathinfo($item->attachment);
                                                    @endphp
                                                    <a href="#" data-type="{{$path_info['extension']}}" data-value="{{asset($item->attachment)}}"><i class="fa fa-paperclip"></i><a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
        @include('layouts.footer')        
    </div>

    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('add.member')}}" method="post" id="add_form">
                    @csrf
                    <input type="hidden" name="course_id" value="{{$course->id}}">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Member</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label w-100">Name<span class="text-danger">*</span></label>
                            <div class="w-100">
                                <select class="form-control" id="member_select" name="members[]" multiple="multiple">
                                    @foreach ($members as $item)
                                        @if ($item->hasCourse($course->id)) @continue @endif
                                        <option value="{{$item->id}}">{{$item->name}}</option>                                                
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">    
                        <button type="submit" class="btn btn-primary">Save</button>                       
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="imageModal">
        <div class="modal-dialog" style="margin-top:17vh">
            <div class="modal-content">
                <img src="" id="image_attach" width="500" height="600" alt="">
            </div>
        </div>
    </div>

    <div class="modal fade" id="pdfModal">
        <div class="modal-dialog modal-lg" style="margin-top:7vh">
            <div class="modal-content">
                <iframe src="" id="pdf_attach" frameborder="0" width="100%" style="height:85vh;"></iframe>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script src="{{asset('master/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('master/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>  
    <script src="{{asset('master/vendors/select2/dist/js/select2.full.min.js')}}"></script>
    <script>
        $(document).ready(function(){

            $('#add_due_to').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });

            $("#member_select").select2();

            $("#btn-add-member").click(function(){
                $("#addModal").modal();
            });



            $(".btn-edit").click(function(){
                let id = $(this).data('id');
                let name = $(this).parents('tr').find('.name').text().trim();
                let description = $(this).parents('tr').find('.description').text().trim();
                let manager = $(this).parents('tr').find('.manager').data('value');
                let company = $(this).parents('tr').find('.company').data('value');
                let due_to = $(this).parents('tr').find('.due_to').text().trim();
                let limit = $(this).parents('tr').find('.limit').data('value');
                let progress = $(this).parents('tr').find('.prog').data('value');

                $("#edit_form .id").val(id);
                $("#edit_form .name").val(name);
                $("#edit_form .description").val(description);
                $("#edit_form .manager").val(manager);
                $("#edit_form .company").val(company);
                $("#edit_form .due_to").val(due_to);
                $("#edit_form .limit").val(limit);
                $("#edit_form .progress").val(progress);
                $("#editModal").modal();
            });

            $("td.attachment a").click(function(e){
                e.preventDefault();
                let type = $(this).data('type');
                let url = $(this).data('value');
                if (type == 'pdf') {
                    $("#pdf_attach").attr('src', url);
                    $("#pdfModal").modal();
                }else{
                    $("#image_attach").attr('src', url);
                    $("#imageModal").modal();
                }
            });
        });
    </script>
@endsection