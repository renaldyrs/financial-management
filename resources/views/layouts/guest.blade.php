<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sepele') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Add Google Font for logo -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .logo-text {
                font-family: 'Poppins', sans-serif;
                font-weight: 700;
                background: linear-gradient(135deg, #4f46e5 0%, #10b981 100%);
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
                text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .logo-container {
                transition: all 0.3s ease;
            }
            .logo-container:hover {
                transform: scale(1.05);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="logo-container mb-8">
                <a href="/" class="flex items-center">
                    <div class="text-4xl md:text-5xl logo-text">
                        Sepele
                    </div>
                    <!-- Optional: Add an icon beside the text -->
                    <!-- <svg class="w-10 h-10 ml-2 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                    </svg> -->
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>