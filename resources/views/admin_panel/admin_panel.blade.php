<!-- Главная страница клиента -->
@extends('../layouts.layout-admin')

    @section('content')

{{--        <admin_panel--}}
{{--            :response="{{json_encode($response)}}"--}}
{{--            :now_lang="{{json_encode($now_lang)}}"--}}
{{--        ></admin_panel>--}}

    @endsection

{{-- JS --}}
@section('scripts')
    @parent
    {{--<script src="{{ asset('js/app1.js') }}"></script>--}}
@endsection
