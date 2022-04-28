@extends('layouts.app')

@section('content')
<div class="container">
    <hidden-vacancies-component
        :lang="{{json_encode($lang)}}"
        :vacancies="{{json_encode($vacancies)}}"
        :settings="{{json_encode($settings)}}"
    ></hidden-vacancies-component>
</div>
@endsection
