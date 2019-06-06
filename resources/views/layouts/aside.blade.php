<!-- START SIDEBAR-->
@php
    $page = config('site.c_page');
    $role = Auth::user()->role->slug;
@endphp
<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <ul class="side-menu metismenu">            
            <li class="@if($page == 'home') active @endif"><a href="{{route('home')}}"><i class="sidebar-item-icon ti-home"></i><span class="nav-label">Dashboard</span></a></li>
            @if($role != 'course_member')
                <li class="@if($page == 'projects') active @endif"><a href="{{route('project.index')}}"><i class="sidebar-item-icon ti-book"></i><span class="nav-label">Project Management</span></a></li>
            @endif
            @if($role == 'course_member')
                <li class="@if($page == 'courses') active @endif"><a href="{{route('member.course')}}"><i class="sidebar-item-icon ti-list"></i><span class="nav-label">My Courses</span></a></li>
            @endif
            <li class="@if($page == 'requests') active @endif"><a href="{{route('request.index')}}"><i class="sidebar-item-icon ti-money"></i><span class="nav-label">Request Management</span></a></li>
            @if($role == 'admin')
                <li class="@if($page == 'users') active @endif"><a href="{{route('user.index')}}"><i class="sidebar-item-icon ti-user"></i><span class="nav-label">User Management</span></a></li>
            @endif
        </ul>
    </div>
</nav>
<!-- END SIDEBAR-->