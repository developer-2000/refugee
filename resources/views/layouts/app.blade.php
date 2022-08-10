<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    {!! \Butschster\Head\Facades\Meta::toHtml() !!}

    @section('style')
    @show

</head>
<body class="skin-blue sidebar-custom sidebar-collapse">
<script src="{{asset('js/jquery-3.6.0.js')}}" ></script>
<script src="{{asset('js/admin_lte/adminlte.min.js')}}" defer></script>

<script>
    var arr1 = [
        "{{asset('css/admin_lte/adminlte.min.css')}}",
    ];
    var arr2 = [
        "{{ asset('css/app.css') }}",
        "{{ asset('css/custom.css') }}",
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
        // setTimeout(function(){
            $('body').css('opacity','1');
        // }, 400);
    });
</script>

    <div id="app">
        <div class="wrapper">

            <!-- left menu -->
{{--            <aside class="main-sidebar sidebar-white elevation-1">--}}
{{--                <!-- Logo -->--}}
{{--                <a href="{{(new \App\Services\LanguageService())->clearPrefixLanguage()}}" class="brand-link" rel="nofollow">--}}
{{--                    <img alt="site logo" src="/img/custom/logo-site.gif">--}}
{{--                    <div class="box-logo-title">--}}
{{--                        <div class="brand-text font-weight-light">--}}
{{--                            {{ env('APP_NAME_UK') }}--}}
{{--                        </div>--}}
{{--                        <div class="brand-text font-weight-light">--}}
{{--                            {{ env('APP_NAME_EN') }}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--                <!-- Menu -->--}}
{{--                <div class="sidebar">--}}
{{--                    <nav class="mt-2">--}}
{{--                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">--}}
{{--                            <li class="nav-item menu-open">--}}
{{--                                <a href="#" class="nav-link active">--}}
{{--                                    <i class="nav-icon fas fa-tachometer-alt"></i>--}}
{{--                                    <p>--}}
{{--                                        Starter Pages--}}
{{--                                        <i class="right fas fa-angle-left"></i>--}}
{{--                                    </p>--}}
{{--                                </a>--}}
{{--                                <ul class="nav nav-treeview">--}}
{{--                                    <li class="nav-item">--}}
{{--                                        <a href="#" class="nav-link active">--}}
{{--                                            <i class="far fa-circle nav-icon"></i>--}}
{{--                                            <p>Active Page</p>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="nav-item">--}}
{{--                                        <a href="#" class="nav-link">--}}
{{--                                            <i class="far fa-circle nav-icon"></i>--}}
{{--                                            <p>Inactive Page</p>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="#" class="nav-link">--}}
{{--                                    <i class="nav-icon fas fa-th"></i>--}}
{{--                                    <p>--}}
{{--                                        Simple Link--}}
{{--                                        <span class="right badge badge-danger">New</span>--}}
{{--                                    </p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </nav>--}}
{{--                </div>--}}
{{--                <!-- / Menu -->--}}
{{--            </aside>--}}
            <!-- / left menu -->

            <top-menu-component
                :logo_text="{{'{"uk":"'.env("APP_NAME_UK").'","en":"'.env("APP_NAME_EN").'"}'}}"
                :lang="{{json_encode($lang)}}"
                :user="{{json_encode($user)}}"
                :count_unread_chats="{{json_encode($count_unread_chats)}}"
                :code_change_password="@if (session('code_change_password')) {{ session('code_change_password') }} @else 0 @endif"
                :transition_url_page="@if (isset($transition_url_page)) {{ json_encode($transition_url_page) }} @else null @endif"
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
                <main-footer
                    :lang="{{json_encode($lang)}}"
                    :app_name=`{{env('APP_NAME_EN')}}`
                ></main-footer>
            </footer>

        </div>
    </div>

<script src="{{ asset('js/app.js') }}" defer></script>
@section('scripts')
    <script>
        (function () {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
        })();
    </script>
@show

</body>
</html>
