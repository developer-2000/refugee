@extends('layouts.show-document')

@section('content')
<div class="container">
    <show-resume-component
        :lang="{{json_encode($lang)}}"
        :respond="{{json_encode($respond)}}"
        :user="{{json_encode($user)}}"
        :back_url="{{json_encode($back_url)}}"
    ></show-resume-component>
</div>
@endsection
