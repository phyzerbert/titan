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
        <ul class="nav navbar-toolbar">
            {{-- <li class="dropdown dropdown-notification">
                <a class="nav-link dropdown-toggle toolbar-icon" data-toggle="dropdown" href="javascript:;"><i class="ti-bell rel"><span class="notify-signal"></span></i></a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                    <div class="dropdown-arrow"></div>
                    <div class="dropdown-header text-center">
                        <div>
                            <span class="font-18"><strong>14 New</strong> Notifications</span>
                        </div>
                        <a class="text-muted font-13" href="javascript:;">view all</a>
                    </div>
                    <div class="p-3">
                        <ul class="timeline scroller" data-height="320px">
                            <li class="timeline-item"><i class="ti-check timeline-icon"></i>2 Issue fixed<small class="float-right text-muted ml-2 nowrap">Just now</small></li>
                            <li class="timeline-item"><i class="ti-announcement timeline-icon"></i>
                                <span>7 new feedback
                                    <span class="badge badge-warning badge-pill ml-2">important</span>
                                </span><small class="float-right text-muted">5 mins</small></li>
                            <li class="timeline-item"><i class="ti-truck timeline-icon"></i>25 new orders sent<small class="float-right text-muted ml-2 nowrap">24 mins</small></li>
                            <li class="timeline-item"><i class="ti-shopping-cart timeline-icon"></i>12 New orders<small class="float-right text-muted ml-2 nowrap">45 mins</small></li>
                            <li class="timeline-item"><i class="ti-user timeline-icon"></i>18 new users registered<small class="float-right text-muted ml-2 nowrap">1 hrs</small></li>
                            <li class="timeline-item"><i class="ti-harddrives timeline-icon"></i>
                                <span>Server Error
                                    <span class="badge badge-success badge-pill ml-2">resolved</span>
                                </span><small class="float-right text-muted">2 hrs</small></li>
                            <li class="timeline-item"><i class="ti-info-alt timeline-icon"></i>
                                <span>System Warning
                                    <a class="text-purple ml-2">Check</a>
                                </span><small class="float-right text-muted ml-2 nowrap">12:07</small></li>
                            <li class="timeline-item"><i class="fa fa-file-excel-o timeline-icon"></i>The invoice is ready<small class="float-right text-muted ml-2 nowrap">12:30</small></li>
                            <li class="timeline-item"><i class="ti-shopping-cart timeline-icon"></i>5 New Orders<small class="float-right text-muted ml-2 nowrap">13:45</small></li>
                            <li class="timeline-item"><i class="ti-arrow-circle-up timeline-icon"></i>Production server up<small class="float-right text-muted ml-2 nowrap">1 days ago</small></li>
                            <li class="timeline-item"><i class="ti-harddrives timeline-icon"></i>Server overloaded 91%<small class="float-right text-muted ml-2 nowrap">2 days ago</small></li>
                            <li class="timeline-item"><i class="ti-info-alt timeline-icon"></i>Server error<small class="float-right text-muted ml-2 nowrap">2 days ago</small></li>
                        </ul>
                    </div>
                </div>
            </li> --}}
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