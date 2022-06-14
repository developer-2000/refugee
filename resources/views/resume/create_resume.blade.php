@extends('layouts.app')
@section('style')
    @parent
    <!-- Select2 -->
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('scripts')
    @parent
    <script src="{{asset('js/select2.min.js')}}" defer></script>
    <!-- InputMask -->
    <script src="{{asset('js/inputmask/jquery.inputmask.bundle.min.js')}}" defer></script>



    <script>
        jQuery(document).ready(function(){
            //Initialize Select2 Elements
            $('.select2').select2()
            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        });
    </script>
@endsection
@section('content')
<div class="container">

    <edit-resume-component
        :lang="{{json_encode($lang)}}"
        :settings="{{json_encode($settings)}}"
    ></edit-resume-component>

</div>
@endsection
