@extends('layouts.app')

@section('content')
<div class="container">
    <my-resumes-component
        :lang="{{json_encode($lang)}}"
        :resumes="{{json_encode($resumes)}}"
        :settings="{{json_encode($settings)}}"
    ></my-resumes-component>
</div>
@endsection
