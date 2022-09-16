<!-- Главная страница клиента -->
    @extends('../layouts.layout-admin')
    @section('content')

        <admin-panel
            :lang="{{json_encode($lang)}}"
            :response="{{json_encode($response)}}"
        ></admin-panel>

    @endsection

{{-- JS --}}
@section('scripts')
    @parent
    {{--<script src="{{ asset('js/app1.js') }}"></script>--}}
@endsection
