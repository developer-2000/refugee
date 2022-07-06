<!-- Главная страница клиента -->
@extends('../layouts.layout-sign-in-admin')

    @section('content')

        <sign-in-component
            :logo_text="{{'{"uk":"'.env("APP_NAME_UK").'","en":"'.env("APP_NAME_EN").'"}'}}"
        ></sign-in-component>

    @endsection

{{-- JS --}}
@section('scripts')
    @parent
    {{--<script src="{{ asset('js/app1.js') }}"></script>--}}
@endsection
