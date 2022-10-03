@extends('layouts.app')
@section('scripts')
    @parent
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@endsection
@section('content')
    <company-component
        :lang="{{json_encode($lang)}}"
        :company="{{json_encode($company)}}"
        :settings="{{json_encode($settings)}}"
        :contact_list="{{json_encode($contact_list)}}"
        :user="{{json_encode($user)}}"
    ></company-component>
@endsection
