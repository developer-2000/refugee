@extends('layouts.app')

@section('content')
    <bookmark-vacancies-component
        :lang="{{json_encode($lang)}}"
        :vacancies="{{json_encode($vacancies)}}"
        :settings="{{json_encode($settings)}}"
    ></bookmark-vacancies-component>
@endsection
