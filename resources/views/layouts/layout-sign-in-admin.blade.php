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

    <link href="{{asset('css/admin_lte/adminlte.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">

</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">
<style type="text/css">
    body { opacity: 0; }
</style>

<!-- jQuery -->
<script src="{{asset('js/jquery-3.6.0.js')}}" ></script>
<script src="{{asset('js/admin_lte/adminlte.min.js')}}"  async></script>
<script src="{{ asset('js/app.js') }}"  defer async></script>

<script>

    $(document).ready(function(){
        setTimeout(function(){
            $('body').css('opacity','1');
        }, 200);
    });

</script>


<!-- Site wrapper -->
<div id="app" class="wrapper">
    @yield('content')
</div>

{{-- JS --}}
@yield('scripts')

</body>
</html>

