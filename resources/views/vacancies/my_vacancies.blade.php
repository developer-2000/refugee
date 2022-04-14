@extends('layouts.app')

@section('content')
<div class="container">
    <my-vacancy-component
        :lang="{{json_encode($lang)}}"
        :user_data="{{json_encode($user_data)}}"
        :settings="{{json_encode($settings)}}"
    ></my-vacancy-component>
</div>
@endsection
