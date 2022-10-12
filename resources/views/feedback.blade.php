@extends('layouts.app')
@section('scripts')
    @parent
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer></script>
@endsection
@section('content')
    <feedback
        :lang="{{json_encode($lang)}}"
        :user="{{json_encode($user)}}"
        :respond="{{json_encode($respond)}}"
    ></feedback>
@endsection
