@extends('layouts.app')

@section('title', 'Список клиентов')

@section('content')
    <div class="overflow-hidden">

        @include('manager.logo')

        <div class="relative flex flex-col items-center justify-center">
            <div class="overflow-x-auto relative">

                <table class="w-full text-sm text-left text-gray-500">
                    <caption class="px-5 text-lg font-semibold text-left text-gray-900">
                        Список клиентов
                        <p class="mt-1 text-sm font-normal text-gray-500">
                            Добавляйте, удаляйте, изменяйте клиентов с помощью таблицы. В поиске вы можете использовать данные из любого столбца.
                        </p>
                        <div class="mb-2 mt-4">
                            <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500">
                            <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900">Отобразить удаленных клиентов</label>
                        </div>
                        <div class="flex">
                            <div class="pb-4 pr-4">
                                <label for="table-search" class="sr-only">Search</label>
                                <div class="relative mt-1">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <input type="text" id="table-search" class="block p-2 pl-10 w-80 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Искать">
                                </div>
                            </div>
                        </div>
                    </caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Фамилия, имя и отчество
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Серийный номер сертификата
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Сертификат действует до
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Действие
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class=" border-b hover:bg-gray-100">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                            Apple MacBook Pro 17"
                        </th>
                        <td class="py-4 px-6">
                            Sliver
                        </td>
                        <td class="py-4 px-6">
                            $2999
                        </td>
                        <td class="py-4 px-6">
                            <a href="#" class="font-medium text-blue-600">Изменить</a>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-100">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                            Microsoft Surface Pro
                        </th>
                        <td class="py-4 px-6">
                            White
                        </td>
                        <td class="py-4 px-6">
                            $1999
                        </td>
                        <td class="py-4 px-6">
                            <a href="#" class="font-medium text-blue-600">Изменить</a>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-100">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                            Magic Mouse 2
                        </th>
                        <td class="py-4 px-6">
                            Black
                        </td>
                        <td class="py-4 px-6">
                            $99
                        </td>
                        <td class="py-4 px-6">
                            <a href="#" class="font-medium text-blue-600">Изменить</a>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-100">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                            Apple Watch
                        </th>
                        <td class="py-4 px-6">
                            Silver
                        </td>
                        <td class="py-4 px-6">
                            $179
                        </td>
                        <td class="py-4 px-6">
                            <a href="#" class="font-medium text-blue-600">Изменить</a>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-100">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                            iPad
                        </th>
                        <td class="py-4 px-6">
                            Gold
                        </td>
                        <td class="py-4 px-6">
                            $699
                        </td>
                        <td class="py-4 px-6">
                            <a href="#" class="font-medium text-blue-600">Изменить</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-100">
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                            Apple iMac 27"
                        </th>
                        <td class="py-4 px-6">
                            Silver
                        </td>
                        <td class="py-4 px-6">
                            $3999
                        </td>
                        <td class="py-4 px-6">
                            <a href="#" class="font-medium text-blue-600">Изменить</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
