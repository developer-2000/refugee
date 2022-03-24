<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <!-- Bootstrap 3.3.7 -->
    <link href="{{ asset('theme/libs/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('theme/libs/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Ionicons -->
    <link href="{{ asset('theme/libs/Ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <!-- Theme style -->
    <link href="{{ asset('theme/css/AdminLTE.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('theme/libs/iCheck/square/blue.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">--}}

    @stack('styles')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
@yield('content')
</html>
