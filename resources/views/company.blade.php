@extends('layouts.app')

@section('content')
<div class="container">

    <company-component
        :lang="{{json_encode($lang)}}"
        :company="{{json_encode($company)}}"
    ></company-component>

</div>
@endsection
