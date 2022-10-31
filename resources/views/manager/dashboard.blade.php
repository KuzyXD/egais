@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <div class="overflow-hidden">

        <logo></logo>

        <div class="relative flex flex-col items-center justify-center gap-8">
            <a href="list/clients"
               class="h-full p-6 rounded-lg border-4 border-sky-300 shadow-xl flex flex-col relative w-9/12 lg:w-6/12 xl:w-5/12 hover:border-light-blue cursor-pointer bg-white">
                <h3 class="text-2xl font-medium">Список клиентов</h3>
                <p class="text-gray-500 text-sm">"Перед созданием заявок для компании важно завести клиента сначала", —
                    цитата великого человека</p>
            </a>

            <a href="list/companies"
               class="h-full p-6 rounded-lg border-4 border-sky-300 shadow-xl flex flex-col relative overflow-hidden w-9/12 lg:w-6/12 xl:w-5/12 hover:border-light-blue cursor-pointer bg-white">
                <h3 class="text-2xl font-medium">Список компаний</h3>
                <p class="text-gray-500 text-sm">Создайте компанию, добавьте тэг к компании и приступайте к шаблонам
                    заявок</p>
            </a>
            <a href="list/applications"
               class="h-full p-6 rounded-lg border-4 border-sky-300 shadow-xl flex flex-col relative overflow-hidden w-9/12 lg:w-6/12 xl:w-5/12 hover:border-light-blue cursor-pointer bg-white">
                <h3 class="text-2xl font-medium">Список заявок</h3>
                <p class="text-gray-500 text-sm">Отслеживайте статус, взаимодействуйте с заявками наших клиентов
                    здесь</p>
            </a>
        </div>
    </div>
@endsection
