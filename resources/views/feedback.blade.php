@extends('layouts.app')

@section('content')
    <feedback
        :lang="{{json_encode($lang)}}"
        :user="{{json_encode($user)}}"
    ></feedback>
@endsection
