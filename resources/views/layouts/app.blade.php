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
    <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- css -->
    <link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

@stack('styles')
</head>
<body>
    <div id="app">
        <div class="wrapper">

            <!-- left menu -->
            <aside class="main-sidebar sidebar-white elevation-1">
                <!-- Logo -->
                <a href="/" class="brand-link">
                    <span class="brand-text font-weight-light">{{ env('APP_NAME_UK') }}</span>
                    <span class="brand-text font-weight-light">{{ env('APP_NAME_EN') }}</span>
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
                :lang="{{json_encode($lang)}}"
                :user="{{json_encode($user)}}"
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
                <strong>Copyright &copy; 2022 <a href="/">{{ env('APP_NAME_EN') }}</a></strong>
            </footer>
        </div>

    </div>

    <!-- jQuery -->
    <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
    <script src="{{asset('adminlte/js/adminlte.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>
