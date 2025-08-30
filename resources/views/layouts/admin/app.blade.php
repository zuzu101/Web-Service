<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title ?? 'LaptopService' }} - Admin Dashboard</title>
    <link rel="icon" href="{{ asset('images/VectorLaptop.png') }}" type="image/png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.admin.components.style')
    @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper">
    @include('layouts.admin.components.navbar')

    @include('layouts.admin.components.sidebar')

  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        @yield('header')
    </section>

    <!-- Main content -->
    <section class="content">
        @yield('content')
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->

    @include('layouts.admin.components.footer')
</div>
<!-- ./wrapper -->
    @include('layouts.admin.components.script')
    @stack('js')
</body>
</html>
