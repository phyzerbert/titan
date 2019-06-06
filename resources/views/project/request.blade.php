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
            <h1 class="page-title">Money Request Management</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="la la-home font-20"></i></a></li>
                <li class="breadcrumb-item">Money Request Management</li>
            </ol>
        </div>
        <div class="page-content fade-in-up">
            <div class="ibox">
                <div class="ibox-body">                                           
                    <div class="text-right mb-4">
                        @if($role == 'admin' || $role == 'accountant')
                            <a href="{{route('request.export')}}" id="btn-export" class="btn btn-info btn-fix"><span class="btn-icon"><i class="la la-file-excel-o"></i>Export</span></a>
                        @endif
                        @if ($role == 'project_manager') 
                            <button type="button" id="btn-add" class="btn btn-primary btn-fix"><span class="btn-icon"><i class="ti-plus"></i>Add New</span></button>
                        @endif
                    </div>
                    <div class="table-responsive row">
                        <table class="table table-bordered table-hover" id="requestsTable">
                            <thead class="thead-default thead-lg">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Project</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Course</th>
                                    <th>Amount</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Attachment</th>
                                    @if ($role == 'admin' || $role == 'accountant')
                                        <th class="text-center">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="text-center">{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="project" data-value="{{$item->course->project->id}}">@isset($item->course->project->id){{$item->course->project->name}}@endisset</td>
                                        <td class="title">{{$item->title}}</td>
                                        <td class="description">{{$item->description}}</td>
                                        <td class="course" data-value="{{$item->course_id}}">@isset($item->course->name){{$item->course->name}}@endisset</td>
                                        <td class="amount">{{$item->amount}}</td>
                                        <td class="text-center py-1">
                                            {{-- @if ($role == 'admin')
                                                <a class="btn btn-sm btn-info btn-fix btn-edit" data-id="{{$item->id}}"><span class="btn-icon text-white"><i class="la la-pencil"></i>Edit</span></a>
                                                <a href="{{route('request.delete', $item->id)}}" class="btn btn-sm btn-danger btn-fix" onclick="return window.confirm('Are you sure?')"><span class="btn-icon text-white"><i class="la la-trash"></i>Remove</span></a>
                                            @elseif($role == 'project_manager') 
                                                <a href="{{route('project.detail', $item->id)}}" class="btn btn-sm btn-info btn-fix btn-manage"><span class="btn-icon text-white"><i class="la la-pencil"></i>Manage</span></a>
                                            @endif --}}
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
                                        @if ($role == 'admin' || $role == 'accountant')
                                            <td class="text-center py-1">
                                                <a class="btn btn-sm @if($item->exceed == 1) btn-danger @else btn-info @endif btn-fix btn-response" data-id="{{$item->id}}" data-exceed={{$item->exceed}}><span class="btn-icon text-white"><i class="la la-comment"></i>Response</span></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix">
                            <div class="float-left" style="margin: 0;">
                                <p>Total <strong style="color: red">{{ $data->total() }}</strong> Requests</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends([])->links() !!}
                            </div>
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
                <form action="{{route('request.create')}}" method="post" id="add_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Request Money</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label text-right mt-1">Title<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="title" id="add_title" placeholder="Reqeust Title" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Project<span class="text-danger">*</span></label>
                            <select name="project_id" id="add_project" class="form-control">
                                <option value="">Select a project</option>
                                @foreach ($projects as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Course<span class="text-danger">*</span></label>
                            <select name="course_id" id="add_course" class="form-control">
                            </select>
                        </div>                        
                        <div class="form-group">
                            <label class="control-label text-right mt-1">Description</label>
                            <input class="form-control" type="text" name="description" id="add_description" placeholder="Description">
                        </div>                        
                        <div class="form-group">
                            <label class="control-label text-right mt-1">Amount<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="amount" id="add_amount" placeholder="Amount" required>
                        </div>                        
                        <div class="form-group">
                            <label class="control-label text-right mt-1">Attachment</label>
                            <input class="form-control form-control-sm" type="file" name="attachment" id="add_attachment" accept="image/*, application/pdf">
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

    <div class="modal fade" id="responseModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('request.response')}}" method="post" id="response_form">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Response To Money Request</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="response_id">
                        <div class="form-group">
                            <label class="control-label text-right mt-1">Project Name</label>
                            <input class="form-control" type="text" name="project" id="response_project" readonly required>
                        </div>
                        <div class="form-group">
                            <label class="control-label text-right mt-1">Title</label>
                            <input class="form-control" type="text" name="title" id="response_title" placeholder="Reqeust Title" readonly required>
                        </div>                        
                        <div class="form-group">
                            <label class="control-label text-right mt-1">Amount</label>
                            <input class="form-control" type="number" name="amount" id="response_amount" placeholder="Amount" readonly required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Response<span class="text-danger">*</span></label>
                            <select name="status" id="add_response" class="form-control">
                                <option value="0">Pending</option>
                                <option value="1">Reject</option>
                                <option value="2">Approve</option>
                            </select>
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
    <script>
        $(document).ready(function(){
            var user_role = '{{Auth::user()->role->slug}}';
            $('#add_due_to').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });

            $("#btn-add").click(function(){
                $("#addModal").modal();
            });

            $("#add_project").change(function(){
                let project_id = $(this).val();
                if(project_id == '') return false;
                $.ajax({
                    url: "{{route('get_courses')}}",
                    data: {project_id: project_id},
                    type: "post",
                    dataType: "json",
                    success: function(data){
                        $("#add_course").html('');
                        for (let i = 0; i < data.length; i++) {
                            const element = data[i];
                            $("#add_course").append(`
                                <option value="${element.id}">${element.name}</option>
                            `);
                        };
                    }
                })
            });

            $(".btn-response").click(function(){
                let id = $(this).data('id');
                let title = $(this).parents('tr').find('.title').text().trim();
                let project = $(this).parents('tr').find('.project').text().trim();
                let amount = $(this).parents('tr').find('.amount').text().trim();
                let exceed = $(this).data('exceed');
                if((exceed == "1" && user_role != 'admin') || (exceed != "1" && user_role != 'accountant')){
                // if(exceed != "1" && user_role != 'accountant'){
                    alert("You can' t respond to exceed limit request");
                    return false;
                }
                $("#response_id").val(id);
                $("#response_project").val(project);
                $("#response_title").val(title);
                $("#response_amount").val(amount);
                $("#responseModal").modal();
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