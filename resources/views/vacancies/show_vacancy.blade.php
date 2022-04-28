@extends('layouts.app')

@section('content')
<div class="container">
    <show-vacancy-component
        :lang="{{json_encode($lang)}}"
        :vacancy="{{json_encode($vacancy)}}"
        :settings="{{json_encode($settings)}}"
    ></show-vacancy-component>
</div>
@endsection
