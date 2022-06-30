@extends('layouts.app')

@section('content')
    <div class="container">
        <index-offer-component
            :user="{{json_encode($user)}}"
            :lang="{{json_encode($lang)}}"
            :respond="{{json_encode($respond)}}"
        ></index-offer-component>
    </div>
@endsection
