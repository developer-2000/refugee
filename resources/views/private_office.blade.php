@extends('layouts.app')

@section('content')
<div class="container">

    <office-component
        :lang="{{json_encode($lang)}}"
        :company="{{json_encode($company)}}"
    ></office-component>

</div>
@endsection
