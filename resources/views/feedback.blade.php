@extends('layouts.app')

@section('content')
    <feedback
        :lang="{{json_encode($lang)}}"
        :user="{{json_encode($user)}}"
        :cap_key="{{json_encode($cap_key)}}"
        :respond="{{json_encode($respond)}}"
    ></feedback>
@endsection
