@extends('layouts.app')

@section('content')
<div class="container">
    <my-vacancies-component
        :lang="{{json_encode($lang)}}"
        :vacancies="{{json_encode($vacancies)}}"
        :settings="{{json_encode($settings)}}"
    ></my-vacancies-component>
</div>
@endsection
