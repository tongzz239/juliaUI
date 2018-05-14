@extends('sidebars.headers.header')

@section('sidebarAndBody')
    <div id="sidebar" class="sidebar-offcanvas">
        <div class="col-lg-12">
            <br>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="/adminPanel/allUsers" class="nav-link {{ $sidebarActive == 1 ? 'active':'' }}">All Users</a>
                </li>
                <li class="nav-item">
                    <a href="/adminPanel/admins" class="nav-link {{ $sidebarActive == 2 ? 'active':'' }}">Admins</a>
                </li>
                <li class="nav-item">
                    <a href="/adminPanel/ordinaryUsers" class="nav-link {{ $sidebarActive == 3 ? 'active':'' }}">Users</a>
                </li>
                <li class="nav-item">
                    <a href="/adminPanel/addNewUser" class="nav-link {{ $sidebarActive == 4 ? 'active':'' }}">Add new user</a>
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
