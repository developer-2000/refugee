@extends('layouts.app')

@section('content')
    <div class="container">
        <index-offer-component
            :lang="{{json_encode($lang)}}"
            :offers="{{json_encode($offers)}}"
        ></index-offer-component>
    </div>
@endsection
