@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <div class="overflow-hidden">

        <logo></logo>

        <div class="relative flex flex-col items-center justify-center gap-8">
            <a href="{{ route('client.application_list') }}"
               class="h-full p-6 rounded-lg border-4 border-sky-300 shadow-xl flex flex-col relative w-9/12 lg:w-6/12 xl:w-5/12 hover:border-light-blue cursor-pointer bg-white">
                <h3 class="text-2xl font-medium">Выбор компании</h3>
                <p class="text-gray-500 text-sm">Выберите компанию из списка</p>
            </a>

            <a href="list/stats"
               class="h-full p-6 rounded-lg border-4 border-sky-300 shadow-xl flex flex-col relative overflow-hidden w-9/12 lg:w-6/12 xl:w-5/12 hover:border-light-blue cursor-pointer bg-white">
                <h3 class="text-2xl font-medium">Статистика</h3>
                <p class="text-gray-500 text-sm">Отслеживайте дату окончания сертификата и др.</p>
            </a>
        </div>
    </div>
@endsection
