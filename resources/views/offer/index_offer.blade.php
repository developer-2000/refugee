@extends('layouts.app')

@section('content')
    <div class="container">
        <index-offer-component
            :user="{{json_encode($user)}}"
            :lang="{{json_encode($lang)}}"
            :offers="{{json_encode($offers)}}"
            :settings="{{json_encode($settings)}}"
        ></index-offer-component>
    </div>
@endsection
