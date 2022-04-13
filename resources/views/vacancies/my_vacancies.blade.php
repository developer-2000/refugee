@extends('layouts.app')

@section('content')
<div class="container">
    <my-vacancy-component
        :lang="{{json_encode($lang)}}"
    ></my-vacancy-component>
</div>
@endsection
