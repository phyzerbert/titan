@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        @php
            $role = Auth::user()->role->slug;
        @endphp
        <!-- START PAGE CONTENT-->
        <div class="page-heading">
            <h1 class="page-title"></h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">التنبيهات<i class="la la-home font-20"></i></a></li>
                <li class="breadcrumb-item">أحدث التنبيهات </li>
            </ol>
        </div>
        <div class="page-content fade-in-up">
            <div class="ibox">
                <div class="flexbox px-4 py-3 bg-primary-50">
                    @if($role == 'admin')
                        <div class="flexbox-b">
                            <label class="checkbox checkbox-primary check-single pt-1">
                                <input type="checkbox" id="select-all" data-select="all">
                                <span class="input-span"></span>
                            </label>
                            <div class="mr-2" id="inbox-actions">
                                <button class="btn btn-sm btn-outline-danger btn-rounded" id="top-delete-btn" data-action="delete" data-toggle="tooltip" data-original-title="Delete"><i class="la la-trash-o"></i>&nbsp;Delete</button>
                            </div>
                        </div>
                    @endif
                    <div class="input-group-icon input-group-icon-left">
                        <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
                        <form action="" method="post">
                            @csrf
                            <input class="form-control form-control-rounded" id="key-search" type="text" name="content" value="{{$content}}" placeholder="Search ...">
                            <button type="submit" class="d-none">Search</button>
                        </form>
                    </div>
                </div>
                <div class="ibox-body">
                    <div class="table-responsive row">                            
                        <table class="table table-hover table-inbox" id="table-inbox">
                            <tbody class="rowlinkx">
                                @foreach ($data as $item) 
                                    @php
                                        $posted_time = new DateTime($item->created_at);
                                        $now = new DateTime();
                                        $interval = $posted_time->diff($now);
                                        if($interval->d >= 1){
                                            $time = $interval->d. " days";
                                        }else if($interval->h >= 1){
                                            $time = $interval->h. " hours";
                                        }else if($interval->i >= 1){
                                            $time = $interval->i. " mins";
                                        }else{
                                            $time = "Just now";
                                        }
                                        
                                    @endphp

                                    <tr data-id="1">
                                        @if ($role == 'admin')                                            
                                            <td class="check-cell rowlink-skip">
                                                <label class="checkbox checkbox-primary check-single">
                                                    <input class="mail-check" data-id="{{$item->id}}" type="checkbox">
                                                    <span class="input-span"></span>
                                                </label>
                                            </td>
                                        @endif
                                        <td>
                                            @switch($item->type)
                                                @case("create_project")
                                                    {{'Created New Project'}}
                                                    @break
                                                @case("new_request")
                                                    {{'New money Request'}}
                                                    @break
                                                @case("exceed_limit")
                                                    {{'Exceed Money Limit'}}
                                                    @break
                                                @case("new_course")
                                                    {{'اضافة برنامج جديد'}}
                                                    @break
                                                @case("completed")
                                                    {{'Completed'}}
                                                    @break
                                                @default
                                                    {{'New Notification'}}
                                            @endswitch   
                                        </td>
                                        <td>
                                            <a class="d-block">{{$item->content}}</a>
                                        </td>
                                        <td class="text-right">{{$time}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix">
                            <div class="float-left" style="margin: 0;">
                                <p>إجمالي <strong style="color: red">{{ $data->total() }}</strong> عنصر</p>
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

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            var selectedmessages = [];
            $("#select-all").change(function(){
                if(this.checked){
                    $(".mail-check").attr("checked", true);
                }else{
                    $(".mail-check").attr("checked", false);
                }
            })

            $("#top-delete-btn").click(function(){
                $(".mail-check:checked").each(function(){
                    selectedmessages.push($(this).data("id"));
                });

                if (selectedmessages.length == 0) {
                    alert("Please select first.");
                    return false;
                }

                if (!confirm("Are you sure?")) {
                    return false;
                }

                var deletemessages = selectedmessages.join();
                console.log(deletemessages);
                $.ajax({
                    url: "{{route('notification.delete')}}",
                    type: "post",
                    data: {deletemessages : deletemessages},
                    success: function(data){
                        if(data == 'success'){
                            alert('Deleted Successfully');
                            window.location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endsection