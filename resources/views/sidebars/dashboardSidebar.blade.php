@extends('sidebars.headers.header')

@section('sidebarAndBody')
    <div id="sidebar" class="sidebar-offcanvas">
        <div class="col-lg-12">
            <br>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="/dashboard/juliaUsage" class="nav-link {{ $sidebarActive == 1 ? 'active':'' }}">Run check</a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/myChecks" class="nav-link {{ $sidebarActive == 2 ? 'active':'' }}">My checks</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link {{ $sidebarActive == 3 ? 'active':'' }}">Section 3</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link {{ $sidebarActive == 4 ? 'active':'' }}">Section 4</a>
                </li>
            </ul>
        </div>
    </div>
    <div id="main">
        <div class="col-lg-12">
            <br>
        	@yield('body')
            <br>
        </div>
    </div>
@endsection
