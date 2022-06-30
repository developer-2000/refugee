@extends('layouts.app')

@section('content')
    <div class="container">
        <show-offer-component
            :user="{{json_encode($user)}}"
            :lang="{{json_encode($lang)}}"
            :respond="{{json_encode($respond)}}"
        ></show-offer-component>
    </div>
@endsection
