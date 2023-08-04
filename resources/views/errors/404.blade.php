<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>404 Not Found</title>
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/TPmY22Z/q.png">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-950 bg-gray-900 flex items-center justify-center">
<div class="mx-auto text-center">
    <img src="/images/error404.png" alt="" class="mx-auto" width="200" height="200">
    <div class="mx-auto">
        <x-button class="mt-4">
            <a href="{{ route('accounts') }}">Home</a>
        </x-button>
    </div>
</div>
</body>
</html>
