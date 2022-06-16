@extends('layouts.app')

@section('content')
<div class="container">
    <bookmark-resumes-component
        :lang="{{json_encode($lang)}}"
        :resumes="{{json_encode($resumes)}}"
        :settings="{{json_encode($settings)}}"
    ></bookmark-resumes-component>
</div>
@endsection
