@extends('layouts.app')

@section('content')
<div class="container">
    <show-vacancy-component
        :lang="{{json_encode($lang)}}"
        :vacancy="{{json_encode($vacancy)}}"
        :settings="{{json_encode($settings)}}"
        :user="{{json_encode($user)}}"
    ></show-vacancy-component>
</div>
@endsection