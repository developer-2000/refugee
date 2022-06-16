@extends('layouts.app')

@section('content')
<div class="container">
    <show-resume-component
        :lang="{{json_encode($lang)}}"
        :resume="{{json_encode($resume)}}"
        :settings="{{json_encode($settings)}}"
        :respond_data="{{json_encode($respond_data)}}"
        :owner_resume="{{json_encode($owner_resume)}}"
        :user="{{json_encode($user)}}"
        :back_url="{{json_encode($back_url)}}"
    ></show-resume-component>
</div>
@endsection
