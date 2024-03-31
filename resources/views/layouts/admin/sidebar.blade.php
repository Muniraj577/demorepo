<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
$menu = 'menu-open';
$active = 'active menu-open';

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('admin.dashboard')}}" class="brand-link">
{{--               <img src="{{asset('assets/images/music.jpeg')}}" alt="Music"--}}
{{--                    class="brand-image  elevation-3" style="opacity: .8">--}}
        <span class="brand-text font-weight-light">Artist Management System</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('assets/images/music.jpeg')}}" class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{getUser()->name}}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link @yield('dashboard')">
                        <i class="nav-icon fas fa-tachometer-alt iCheck"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @include('layouts.admin.sidebar.allnav')
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
</aside>
