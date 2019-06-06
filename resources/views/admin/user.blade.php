@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- START PAGE CONTENT-->
        <div class="page-heading">
            <h1 class="page-title">User Management</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="la la-home font-20"></i></a></li>
                <li class="breadcrumb-item">User Management</li>
            </ol>
        </div>
        <div class="page-content fade-in-up">
            <div class="ibox">
                <div class="ibox-body">
                    <div class="text-right mb-4">
                        <button type="button" id="btn-add" class="btn btn-primary btn-fix"><span class="btn-icon"><i class="ti-plus"></i>Add New</span></button>
                    </div>
                    <div class="table-responsive row">
                        <table class="table table-bordered table-hover" id="usersTable">
                            <thead class="thead-default thead-lg">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created at</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="text-center">{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="email">{{$item->email}}</td>
                                        <td>{{$item->role->name}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td class="text-center py-1">
                                            <a class="btn btn-sm btn-info btn-fix btn-edit" data-id="{{$item->id}}"><span class="btn-icon text-white"><i class="la la-pencil"></i>Edit</span></a>
                                            <a href="{{route('user.delete', $item->id)}}" class="btn btn-sm btn-danger btn-fix" onclick="return window.confirm('Are you sure?')"><span class="btn-icon text-white"><i class="la la-trash"></i>Remove</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix">
                            <div class="float-left" style="margin: 0;">
                                <p>Total <strong style="color: red">{{ $data->total() }}</strong> Users</p>
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
                <form action="{{route('user.create')}}" method="post" id="add_form">
                    @csrf
                    <input type="hidden" name="role_id" value="3" />
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Project Manager</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label text-right mt-1">Name<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" id="add_name" placeholder="Name" required>
                            <span id="name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="form-group">
                            <label class="control-label text-right mt-1">Email Address<span class="text-danger">*</span></label>
                            <input class="form-control" type="email" name="email" id="add_email" placeholder="Email Address" required >
                            <span id="email_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="form-group">
                            <label class="control-label text-right mt-1">Role<span class="text-danger">*</span></label>
                            <select class="form-control role" type="email" name="role_id" id="add_role" required >
                                <option value="4">Course Member</option>
                                <option value="3">Project Manager</option>
                                <option value="2">Accountant</option>
                                <option value="1">Admin</option>
                            </select>
                            <span id="role_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="form-group password-field">
                            <label class="control-label">Password</label>
                            <input type="password" name="password" id="add_password" class="form-control" placeholder="Password">
                            <span id="password_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
    
                        <div class="form-group password-field">
                            <label class="control-label">Password Confirm</label>
                            <input type="password" name="password_confirmation" id="add_confirmpassword" class="form-control" placeholder="Password Confirm">
                        </div>

                    </div>
                    
                    <div class="modal-footer">    
                        <button type="submit" class="btn btn-primary ml-2">Save</button>                       
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('user.edit')}}" method="post" id="edit_form">
                    @csrf
                    <input type="hidden" class="id" name="id" />
                    <div class="modal-header">
                        <h4 class="modal-title">Edit User</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label text-right mt-1">Name<span class="text-danger">*</span></label>
                            <input class="form-control name" type="text" name="name" id="edit_name" placeholder="Name" required>
                            <span id="name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="form-group">
                            <label class="control-label text-right mt-1">Email Address<span class="text-danger">*</span></label>
                            <input class="form-control email" type="email" name="email" id="edit_email" placeholder="Email Address" required >
                            <span id="email_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>

                        <div class="form-group password-field">
                            <label class="control-label">Password</label>
                            <input type="password" name="password" id="edit_password" class="form-control" placeholder="Password">
                            <span id="password_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
    
                        <div class="form-group password-field">
                            <label class="control-label">Password Confirm</label>
                            <input type="password" name="password_confirmation" id="edit_confirmpassword" class="form-control" placeholder="Password Confirm">
                        </div>

                    </div>
                    
                    <div class="modal-footer">    
                        <button type="submit" class="btn btn-primary ml-2">Save</button>                       
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#btn-add").click(function(){
                $("#addModal").modal();
            });

            $(".btn-edit").click(function(){
                let id = $(this).data('id');
                let name = $(this).parents('tr').find('.name').text().trim();
                let email = $(this).parents('tr').find('.email').text().trim();

                $("#edit_form .id").val(id);
                $("#edit_form .name").val(name);
                $("#edit_form .email").val(email);
                $("#editModal").modal();
            });
        });
    </script>
@endsection