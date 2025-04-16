<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script src="https://kit.fontawesome.com/d4498571f5.js" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        
        <!-- Custom CSS -->
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[url('https://ict-flex.nl/wp-content/uploads/2023/10/deltion3large.webp')] bg-cover">
        <div class="h-screen flex justify-center items-center flex-col gap-[60px] font-[Inter] bg-[#000000]/60">
            <div>
                <a href="/">
                    <x-application-logo />
                </a>
            </div>

            <div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>