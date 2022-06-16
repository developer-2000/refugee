@extends('layouts.app')

@section('content')
<div class="container">
    <hidden-resumes-component
        :lang="{{json_encode($lang)}}"
        :resumes="{{json_encode($resumes)}}"
        :settings="{{json_encode($settings)}}"
    ></hidden-resumes-component>
</div>
@endsection
