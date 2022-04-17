@extends('layouts.app')
@section('style')
    @parent
    <!-- Select2 -->
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('scripts')
    @parent
    <script src="{{asset('js/select2.min.js')}}" defer></script>
    <script>
        jQuery(document).ready(function(){
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
@endsection

@section('content')
<div class="container">

    <search-vacancy
        :lang="{{json_encode($lang)}}"
        :settings="{{isset($settings) ? json_encode($settings) : json_encode(null)}}"
    ></search-vacancy>
</div>
@endsection
