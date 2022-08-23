@extends('layouts.app')

@section('content')
    <feedback
        :lang="{{json_encode($lang)}}"
        :user="{{json_encode($user)}}"
        :respond="{{json_encode($respond)}}"
    ></feedback>
@endsection
