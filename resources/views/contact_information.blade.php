@extends('layouts.app')

@section('content')
<div class="container">
    <contact_information
        :lang="{{json_encode($lang)}}"
    ></contact_information>
</div>
@endsection
