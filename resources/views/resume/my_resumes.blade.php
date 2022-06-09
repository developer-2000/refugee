@extends('layouts.app')

@section('content')
<div class="container">
    <my-resume-component
        :lang="{{json_encode($lang)}}"
        :resumes="{{json_encode($resumes)}}"
    ></my-resume-component>
</div>
@endsection
