<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/admin_lte/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- css -->
    <link rel="stylesheet" href="{{asset('css/admin_lte/adminlte.min.css')}}">

    @section('style')
    @show
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

</head>
<body class="skin-blue sidebar-custom sidebar-collapse">

    <div id="app">
        <div class="wrapper">

            <!-- left menu -->
            <aside class="main-sidebar sidebar-white elevation-1">
                <!-- Logo -->
                <a href="{{$lang['prefix_lang']}}" class="brand-link">
                    <img alt="" src="/img/custom/logo-site.gif">
                    <div class="box-logo-title">
                        <div class="brand-text font-weight-light">
                            {{ env('APP_NAME_UK') }}
                        </div>
                        <div class="brand-text font-weight-light">
                            {{ env('APP_NAME_EN') }}
                        </div>
                    </div>
                </a>

                <!-- Menu -->
                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Starter Pages
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link active">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Active Page</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Inactive Page</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Simple Link
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- / Menu -->
            </aside>
            <!-- / left menu -->

            <top-menu-component
                :logo_text="{{'{"uk":"'.env("APP_NAME_UK").'","en":"'.env("APP_NAME_EN").'"}'}}"
                :lang="{{json_encode($lang)}}"
                :user="{{json_encode($user)}}"
                :respond="{{json_encode($respond)}}"
                :code_change_password="@if (session('code_change_password')) {{ session('code_change_password') }} @else 0 @endif"
            ></top-menu-component>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('link_not_valid'))
                <div class="alert alert-danger">
                    {{ session('link_not_valid') }}
                </div>
            @endif


            <!-- Content body -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- / Content body -->

            <footer class="main-footer">
                <strong>Copyright &copy; 2022 <a href="{{$lang['prefix_lang']}}">{{ env('APP_NAME_EN') }}</a></strong>
            </footer>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{asset('js/jquery-3.6.0.js')}}" ></script>
    <script src="{{asset('js/admin_lte/adminlte.min.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="http://momentjs.com/downloads/moment.js"></script>
    <script src="https://momentjs.com/downloads/moment-timezone-with-data.min.js"></script>

@section('scripts')
{{--    <script>--}}
{{--        jQuery(document).ready(function(){--}}
{{--            // let time = moment("2020-10-21 17:10:29").fromNow()--}}

{{--            var now = new Date();--}}
{{--            var utc = now.getTime() + (now.getTimezoneOffset() * 60000);--}}
{{--            var startTime = new Date('2022-06-10 11:28:50')--}}
{{--            // var timezone = startTime.getTimezoneOffset()--}}

{{--            // var startTime2 = startTime.toUTCString()--}}
{{--            // var startTime2 = moment('2022-06-10 10:05:48.000000')--}}

{{--                // .getTimeZoneOffset()--}}


{{--            // console.log(now)--}}
{{--            console.log(startTime.getTimezoneOffset())--}}
{{--            // console.log(startTime2)--}}

{{--            var timeDiff = moment.duration(utc - startTime);--}}

{{--            var timeMessege = 'Время исследования: ' +--}}
{{--                timeDiff.years() + ' м ' +--}}
{{--                timeDiff.months() + ' м ' +--}}
{{--                timeDiff.days() + ' м ' +--}}
{{--                timeDiff.hours() + ' ч ' +--}}
{{--                timeDiff.minutes() + ' м ' +--}}
{{--                timeDiff.seconds() + ' с';--}}

{{--            console.log(timeMessege)--}}

{{--        });--}}
{{--    </script>--}}
@show
</body>
</html>
