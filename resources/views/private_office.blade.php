@extends('layouts.app')

@section('content')
<div class="container">

    <office-component
        :lang="{{json_encode($lang)}}"
    ></office-component>

</div>
@endsection
