@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <div class="overflow-y-hidden">
        <crypto-pro-setup></crypto-pro-setup>
        <logo></logo>

        <application-action :applicationId="{{\Illuminate\Support\Facades\Request::query('id')}}"
                            :allowedStatuses='{!! json_encode(config('PNK.ALLOWED_STATUSES_FOR_CLIENT_ACTION')) !!}'></application-action>
    </div>
@endsection
