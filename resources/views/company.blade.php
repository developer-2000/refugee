@extends('layouts.app')

@section('content')
    <company-component
        :lang="{{json_encode($lang)}}"
        :company="{{json_encode($company)}}"
        :settings="{{json_encode($settings)}}"
        :user="{{json_encode($user)}}"
    ></company-component>
@endsection
