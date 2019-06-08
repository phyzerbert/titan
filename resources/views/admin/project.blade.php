@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" />    
    <link href="{{asset('master/vendors/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        <div class="page-heading">
            <h1 class="page-title">إدارة المشاريع</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="la la-home font-20"></i></a></li>
                <li class="breadcrumb-item">إدارة المشاريع</li>
            </ol>
        </div>
        <div class="page-content fade-in-up">
            <div class="ibox">
                <div class="ibox-body">
                    <div class="text-right mb-4">
                        <button type="button" id="btn-add" class="btn btn-primary btn-fix"><span class="btn-icon"><i class="ti-plus"></i>أضف مشروع</span></button>
                    </div>
                    <div class="table-responsive row">
                        <table class="table table-bordered table-hover" id="usersTable">
                            <thead class="thead-default thead-lg">
                                <tr>
                                    <th class="text-center">رقم</th>
                                    <th>الإسم</th>
                                    <th>المدير</th>
                                    <th>الشركة</th>
                                    <th>الوصف</th>
                                    <th>تاريخ البدء</th>
                                    <th>حد الصرف</th>
                                    <th>مؤشر الإنجاز</th>
                                    <th class="text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="text-center">{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="manager" data-value="{{$item->user_id}}">@isset($item->user->name){{$item->user->name}}@endisset</td>
                                        <td class="company" data-value="{{$item->company_id}}">@isset($item->company->name){{$item->company->name}}@endisset</td>
                                        <td class="description">{{$item->description}}</td>
                                        <td class="due_to">{{$item->due_to}}</td>
                                        <td class="limit" data-value="{{$item->limit}}">{{$item->limit}}</td>
                                        <td class="prog" data-value="{{$item->progress}}">{{$item->progress}}%</td>
                                        <td class="text-center py-1">
                                            <a class="btn btn-sm btn-info btn-fix btn-edit" data-id="{{$item->id}}"><span class="btn-icon text-white"><i class="la la-pencil"></i>تعديل</span></a>
                                            <a href="{{route('project.delete', $item->id)}}" class="btn btn-sm btn-danger btn-fix" onclick="return window.confirm('Are you sure?')"><span class="btn-icon text-white"><i class="la la-trash"></i>حذف</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix">
                            <div class="float-left" style="margin: 0;">
                                <p>اجمالي <strong style="color: red">{{ $data->total() }}</strong> المشاريع</p>
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
                <form action="{{route('project.create')}}" method="post" id="add_form">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">أضف مشروع جديد</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label text-right mt-1">إسم المشروع (ورقم العقد )<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" id="add_name" placeholder="Name" required>
                            <span id="name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="form-group">
                            <label class="control-label">مدير المشروع<span class="text-danger">*</span></label>
                            <select name="user_id" id="add_manager" class="form-control" placeholder="Manager">
                                <option value=""> اختر مدير للمشروع</option>
                                @foreach ($managers as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <span id="manager_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>                        
                        
                        <div class="form-group">
                            <label class="control-label">الشركة <span class="text-danger">*</span></label>
                            <select name="company_id" id="add_company" class="form-control" placeholder="Company">
                                <option value="">اختر الشركة </option>
                                @foreach ($companies as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <span id="company_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="form-group">
                            <label class="control-label text-right mt-1">وصف المشروع<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" id="add_description" rows="4" placeholder="Description" required></textarea>
                            <span id="email_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>                        
                        <div class="form-group">
                            <label class="control-label text-right mt-1">تاريخ العمل<span class="text-danger">*</span></label>
                            <div class="input-group date">
                                <span class="input-group-addon bg-white"><i class="fa fa-calendar"></i></span>
                                <input class="form-control" type="text" name="due_to" id="add_due_to" autocomplete="off" />
                            </div>
                            <span id="due_to_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label text-right mt-1">حد الصرف<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="limit" id="add_limit" placeholder="p] hgwvt" required>
                            <span id="limit_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    
                    <div class="modal-footer">    
                        <button type="submit" class="btn btn-primary">حفظ</button>                       
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('project.edit')}}" method="post" id="edit_form">
                    @csrf
                    <input type="hidden" class="id" name="id" />
                    <div class="modal-header">
                        <h4 class="modal-title">تعديل المشروع</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label text-right mt-1">الإسم<span class="text-danger">*</span></label>
                            <input class="form-control name" type="text" name="name" id="edit_name" placeholder="Name" required>
                            <span id="name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="form-group password-field">
                            <label class="control-label">مدير المشروع<span class="text-danger">*</span></label>
                            <select name="user_id" id="edit_manager" class="form-control manager" placeholder="Manager">
                                <option value="">اختر مدير المشروع</option>
                                @foreach ($managers as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <span id="manager_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="form-group">
                            <label class="control-label">الشركة<span class="text-danger">*</span></label>
                            <select name="company_id" id="add_company" class="form-control company" placeholder="Company">
                                <option value="">اختر الشركة </option>
                                @foreach ($companies as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <span id="company_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="form-group">
                            <label class="control-label text-right mt-1">الوصف<span class="text-danger">*</span></label>
                            <textarea class="form-control description" name="description" id="edit_description" rows="4" placeholder="Description" required></textarea>
                            <span id="email_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="form-group">
                            <label class="control-label text-right mt-1">تاريخ بدء العمل<span class="text-danger">*</span></label>
                            <div class="input-group date">
                                <span class="input-group-addon bg-white"><i class="fa fa-calendar"></i></span>
                                <input class="form-control due_to" type="text" name="due_to" id="edit_due_to" autocomplete="off" />
                            </div>
                            <span id="due_to_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label text-right mt-1">حد الصرف<span class="text-danger">*</span></label>
                            <input class="form-control limit" type="number" name="limit" id="edit_limit" placeholder="حد الصرف" required>
                            <span id="limit_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>الإنجاز</label>
                            <input class="form-control progress" name="progress" type="text">
                        </div>
                    </div>
                    
                    <div class="modal-footer">    
                        <button type="submit" class="btn btn-primary">حفظ</button>                       
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script src="{{asset('master/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('master/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>    
    <script src="{{asset('master/vendors/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js')}}"></script>
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

            $("#btn-add").click(function(){
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

            $("#edit_form .progress").TouchSpin({
                min: 0,
                max: 100,
                step: 1,
                boostat: 5,
                maxboostedstep: 10,
                postfix: '%',
            });
        });
    </script>
@endsection