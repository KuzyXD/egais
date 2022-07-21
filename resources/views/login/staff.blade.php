@extends('layouts.app')

@section('title', 'Авторизация сотрудника')

@section('content')
    <staff-login :logo="'{{ asset('/img/pnk.png') }}'"></staff-login>
@endsection
