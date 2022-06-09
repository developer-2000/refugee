@extends('layouts.app')

@section('content')
<div class="container">
    <my-vacancy-component
        :lang="{{json_encode($lang)}}"
        :vacancies="{{json_encode($vacancies)}}"
        :settings="{{json_encode($settings)}}"
    ></my-vacancy-component>
</div>
@endsection
