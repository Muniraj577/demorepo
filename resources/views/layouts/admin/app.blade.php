<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ env('APP_NAME') }} @hasSection('title') | @yield('title') @endif
</title>
<link rel="icon" href="{{ asset('assets/frontend/images/favicon.png') }}" type="image/*" sizes="16x16">
@include('layouts.admin.style')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('layouts.admin.header')

    <!-- Main Sidebar Container -->

    @include('layouts.admin.sidebar')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="app">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.admin.footer')

</div>
<!-- ./wrapper -->
@include('layouts.admin.script')
</body>

</html>
