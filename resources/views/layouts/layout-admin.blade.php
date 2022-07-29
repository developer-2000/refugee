<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @section('style')
    @show

</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">
<script src="{{asset('js/jquery-3.6.0.js')}}" ></script>
<script src="{{asset('js/admin_lte/adminlte.min.js')}}" defer></script>
<script>
    var arr1 = [
        "{{asset('css/admin_lte/adminlte.min.css')}}",
    ];
    var arr2 = [
        "{{ asset('css/app.css') }}",
        "{{ asset('css/admin.css') }}",
        "https://use.fontawesome.com/releases/v5.0.13/css/all.css",
    ];

    arr1.forEach(function(name, i, arr) {
        var link = document.createElement("link");
        // для IE8
        var head = document.head || document.getElementsByTagName('head')[0];
        link.href = name;
        link.rel = "stylesheet";
        head.prepend(link);
    });
    arr2.forEach(function(name, i, arr) {
        var link = document.createElement("link");
        // для IE8
        var head = document.head || document.getElementsByTagName('head')[0];
        link.href = name;
        link.rel = "stylesheet";
        head.append(link);
    });
    $(document).ready(function(){
        setTimeout(function(){
            $('body').css('opacity','1');
        }, 200);
    });
</script>

<!-- Site wrapper -->
<div id="app" class="wrapper">
    {{-- верхнее меню --}}
    <top-navigation-bar></top-navigation-bar>
    {{-- боковое меню --}}
    <left_sidebar
        :logo_text="{{json_encode($logo_text)}}"
    ></left_sidebar>

    <div class="content-wrapper">
        @yield('content')
    </div>

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.0-rc.5
        </div>
        <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>
</div>

<script src="{{ asset('js/app.js') }}" defer></script>
{{-- JS --}}
@section('scripts')
    <script>
        jQuery(document).ready(function(){

        });
    </script>
@show

</body>
</html>

