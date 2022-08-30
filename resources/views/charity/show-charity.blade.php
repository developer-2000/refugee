@extends('layouts.app')

@section('content')

    <show-charity
        :lang="{{json_encode($lang)}}"
        :response="{{json_encode($response)}}"
    ></show-charity>

@endsection


