@extends('layouts.app')

@section('content')
<div class="container">

    <create-vacancy-component
        :lang="{{json_encode($lang)}}"
        :settings="{{json_encode($settings)}}"
    ></create-vacancy-component>

</div>
@endsection
