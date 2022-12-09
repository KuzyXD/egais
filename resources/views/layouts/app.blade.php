<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>КЦР — @yield('title')</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="{{ asset('js/flowbite.js') }}"></script>
</head>

<body>
<div id="app" class="bg-gray-50 h-screen">
    @yield('content')
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
