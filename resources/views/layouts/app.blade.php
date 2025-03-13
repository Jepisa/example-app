<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .toast-message {
                position: fixed;
                top: 5%;
                left: 40%;
                transform: translate(-5%, -40%); 
                background-color: #28a745;
                color: white;
                padding: 15px;
                border-radius: 5px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                z-index: 9999;
                font-size: 16px;
                display: none;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            @if(session('success'))
                <div id="toastMessage" class="toast-message">
                    {{ session('success') }}
                </div>
            @endif

        </div>

        <script>
           
            window.onload = function() {
                var toastMessage = document.getElementById('toastMessage');
                if (toastMessage) {
                    toastMessage.style.display = 'block'; 

                    
                    setTimeout(function() {
                        toastMessage.style.display = 'none';
                    }, 3000);
                }
            };
        </script>
    </body>
</html>

