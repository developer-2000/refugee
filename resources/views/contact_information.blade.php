@extends('layouts.app')

@section('content')
<div class="container">
    <contact_information
        :lang="{{json_encode($lang)}}"
        :contact="{{json_encode($contact)}}"
        :settings="{{json_encode($settings)}}"
    ></contact_information>
</div>
@endsection
