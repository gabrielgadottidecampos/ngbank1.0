@extends('layouts.app')
@yield('menuprincipal')
@section('content')
    <body class="bodymelhoresdodia">
    <melhoresdodia-component></melhoresdodia-component>
    </body>
@endsection
<style>
    .bodymelhoresdodia{
        background: #2E95EF;
        background-image: -moz-radial-gradient(center 45deg,circle cover, #9BD1FF, #2E95EF);
        background-image: -webkit-gradient(radial, 50% 50%, 0, 50% 50%,800, from(#9BD1FF), to(#2E95EF));
        padding-top: 5%;
    }
</style>
