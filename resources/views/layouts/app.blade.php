<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

{{--    <meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <meta name="viewport" content="width=device-width, user-scalable=no">--}}

    {!! \Butschster\Head\Facades\Meta::toHtml() !!}

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('/img/custom/favicon/apple-touch-icon-144x144.png')}}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{asset('/img/custom/favicon/apple-touch-icon-152x152.png')}}" />
    <link rel="icon" type="image/png" href="{{asset('/img/custom/favicon/favicon-32x32.png')}}" sizes="32x32" />
    <meta name="application-name" content="&nbsp;"/>
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="mstile-144x144.png" />

{{--    <meta property="og:type" content="website">--}}
{{--    <meta property="og:site_name" content="Название сайта">--}}
{{--    <meta property="og:title" content="Заголовок">--}}
{{--    <meta property="og:description" content="Описание страницы">--}}
{{--    <meta property="og:url" content="http://mysite.com/post">--}}
{{--    <meta property="og:locale" content="ru_RU">--}}
{{--    <meta property="og:image" content="http://mysite.com/thumbnail.jpg">--}}
{{--    <meta property="og:image:width" content="968">--}}
{{--    <meta property="og:image:height" content="504">--}}

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
    // $(document).ready(function(){
    //     // setTimeout(function(){
    //         $('body').css('opacity','1');
    //     // }, 400);
    // });
</script>

    <div id="app">
        <div class="wrapper">

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
                <div class="footer-line-border"></div>
                <div class="bottom-footer">
                    <main-footer
                        :lang="{{json_encode($lang)}}"
                        :app_name="{{json_encode(env('APP_NAME_EN'))}}"
                    ></main-footer>
                </div>
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
