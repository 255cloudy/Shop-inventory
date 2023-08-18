<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buddies</title>
    <link rel = "icon" href =
        "{{ asset('img/B.svg') }}"
          type = "image/x-icon">
    <link rel="stylesheet" href="{{asset("css/app.css")}}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('css/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/plugins/fontawesome-free/css/v4-shims.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}} ">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/dist/css/adminlte.min.css')}}">

    @yield('extra-css')
</head>
<body>

{{--main body--}}


{{--<!-- Preloader -->--}}
{{--<div class="preloader flex-column justify-content-center align-items-center">--}}
{{--    <img class="animation__wobble" src="{{  asset('img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">--}}
{{--</div>--}}
<!-- end of preloader -->

{{--start of navbar--}}
<!-- Navbar -->
<x-top-bar></x-top-bar>
<!-- /.navbar -->
{{--navbar end--}}
{{--end of main body--}}

{{--start of sidebar--}}
<!-- Main Sidebar Container -->
<x-side-bar></x-side-bar>
{{--end of sidebar--}}
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ Route::currentRouteName()  }} </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ route("dashboard") }}</a></li>
                        <li class="breadcrumb-item active">{{ Route::currentRouteName() }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="container-fluid">
            @yield("main-content")
        </div>

    </div>
</div>
{{--footer--}}
<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">wazo.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 0.1
    </div>
</footer>
{{--end of footer--}}


{{--scripts--}}
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('js/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('js/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('js/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src=" {{ asset('js/dist/js/adminlte.js') }}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{  asset('js/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{ asset('js/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('js/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{ asset('js/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{ asset('js/plugins/chart.js/Chart.min.js')}}"></script>
@yield('extra-js')
{{--end of scripts--}}
</body>
</html>

