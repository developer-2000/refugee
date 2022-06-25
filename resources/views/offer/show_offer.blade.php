@extends('layouts.app')

@section('content')
    <div class="container">
        <show-offer-component
            :user="{{json_encode($user)}}"
            :lang="{{json_encode($lang)}}"
            :offer="{{json_encode($offer)}}"
            :settings="{{json_encode($settings)}}"
        ></show-offer-component>
    </div>
@endsection
