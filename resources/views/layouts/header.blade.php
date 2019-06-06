<!-- START HEADER-->
<header class="header">
    <div class="page-brand">
        <a href="/" class="mx-auto">
            <span class="brand">{{config('app.name')}}</span>
            <span class="brand-mini">{{Auth::user()->role->name}}</span>
        </a>
    </div>
    <div class="flexbox flex-1">
        <!-- START TOP-LEFT TOOLBAR-->
        <ul class="nav navbar-toolbar">
            <li>
                <a class="nav-link sidebar-toggler js-sidebar-toggler" href="javascript:;">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </li>
        </ul>
        <!-- END TOP-LEFT TOOLBAR-->
        <!-- START TOP-RIGHT TOOLBAR-->
        @php
            $recent_messages = \App\Models\Notification::orderBy('created_at', 'desc')->limit(10)->get();
        @endphp
        <ul class="nav navbar-toolbar">
            <li class="dropdown dropdown-notification">
                <a class="nav-link dropdown-toggle toolbar-icon" data-toggle="dropdown" href="javascript:;"><i class="ti-bell rel"><span class="notify-signal"></span></i></a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                    <div class="dropdown-arrow"></div>
                    {{-- <div class="dropdown-header text-center">
                        <div>
                            <span class="font-18"><strong>14 New</strong> Notifications</span>
                        </div>
                        <a class="text-muted font-13" href="javascript:;">view all</a>
                    </div> --}}
                    <div class="p-3">
                        <ul class="timeline scroller" data-height="250px">
                            @foreach ($recent_messages as $item)
                                <a 
                                    @switch($item->type)
                                        @case("create_project")
                                            href="{{route('project.index')}}"
                                            @break
                                        @case("new_request")
                                            href="{{route('request.index')}}"
                                            @break
                                        @case("exceed_limit")
                                            href="{{route('request.index')}}"
                                            @break
                                        @case("new_course")
                                            href="{{route('course.detail', $item->link)}}"
                                            @break
                                        @case("completed")
                                            href="{{route('project.index')}}"
                                            @break
                                        @default
                                            href="{{route('project.index')}}"
                                    @endswitch                                
                                >
                                    <li class="timeline-item">
                                        @switch($item->type)
                                            @case("create_project")
                                                <i class="ti-check timeline-icon"></i>
                                                @break
                                            @case("new_request")
                                                <i class="fa fa-file-excel-o timeline-icon"></i>
                                                @break
                                            @case("exceed_limit")
                                                <i class="fa fa-file-excel-o timeline-icon"></i>
                                                @break
                                            @case("new_course")
                                                <i class="fa fa-file-excel-o timeline-icon"></i>
                                                @break
                                            @case("completed")
                                                <i class="ti-announcement timeline-icon"></i>
                                                @break
                                            @default
                                                <i class="fa fa-file-excel-o timeline-icon"></i>
                                        @endswitch                                    
                                        {{$item->content}}
                                    </li>
                                </a>
                            @endforeach
                            {{-- <li class="timeline-item"><i class="ti-check timeline-icon"></i>2 Issue fixed</li>
                            <li class="timeline-item"><i class="ti-announcement timeline-icon"></i>7 new feedback</li>
                            <li class="timeline-item"><i class="ti-truck timeline-icon"></i>25 new orders sent</li>
                            <li class="timeline-item"><i class="ti-shopping-cart timeline-icon"></i>12 New orders</li>
                            <li class="timeline-item"><i class="ti-user timeline-icon"></i>18 new users registered</li>
                            <li class="timeline-item"><i class="fa fa-file-excel-o timeline-icon"></i>The invoice is ready</li>
                            <li class="timeline-item"><i class="ti-shopping-cart timeline-icon"></i>5 New Orders</li>
                            <li class="timeline-item"><i class="ti-arrow-circle-up timeline-icon"></i>Production server up</li>
                            <li class="timeline-item"><i class="ti-harddrives timeline-icon"></i>Server overloaded 91%</li>
                            <li class="timeline-item"><i class="ti-info-alt timeline-icon"></i>Server error</li> --}}
                        </ul>
                    </div>
                </div>
            </li>
            <li class="dropdown dropdown-user">
                <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                    <span>{{Auth::user()->name}}</span>
                    <img src="@if (isset(Auth::user()->picture)){{asset(Auth::user()->picture)}} @else {{asset('images/avatar128.png')}} @endif" alt="User Image" />
                </a>
                <div class="dropdown-menu dropdown-arrow dropdown-menu-right admin-dropdown-menu">
                    <div class="dropdown-arrow"></div>
                    <div class="dropdown-header">
                        <div class="admin-avatar">
                            <img src="@if (isset(Auth::user()->picture)){{asset(Auth::user()->picture)}} @else {{asset('images/avatar128.png')}} @endif" alt="User Image" />
                        </div>
                        <div>
                            <h5 class="font-strong text-white">{{Auth::user()->name}}</h5>
                            <div>
                                <span class="admin-badge"><i class="ti-alarm-clock mr-2"></i>{{Auth::user()->role->name}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="admin-menu-features">
                        <a class="admin-features-item" href="{{route('profile')}}"><i class="ti-user"></i>
                            <span>PROFILE</span>
                        </a>
                        <a class="admin-features-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            <i class="ti-shift-right"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
                    </div>
                </div>
            </li>
        </ul>
        <!-- END TOP-RIGHT TOOLBAR-->
    </div>
</header>
<!-- END HEADER-->