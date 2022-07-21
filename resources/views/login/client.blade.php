@extends('layouts.app')

@section('title', 'Авторизация клиента')

@section('content')
    <client-login-page :logo="'{{ asset('/img/pnk.png') }}'"></client-login-page>
@endsection
