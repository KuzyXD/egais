@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <div class="overflow-y-hidden">
        <logo></logo>

        <application-list-client></application-list-client>
    </div>
@endsection
