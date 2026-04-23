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
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-50 via-white to-slate-100">
            <div class="absolute top-4 right-4 flex items-center gap-1 rounded-full border border-slate-200 bg-white/80 p-1 text-xs font-semibold text-slate-600 shadow-sm">
                <a href="{{ route('locale.switch', 'en') }}" class="rounded-full px-2 py-1 {{ app()->currentLocale() === 'en' ? 'bg-slate-900 text-white' : 'hover:bg-slate-100' }}">EN</a>
                <a href="{{ route('locale.switch', 'bn') }}" class="rounded-full px-2 py-1 {{ app()->currentLocale() === 'bn' ? 'bg-slate-900 text-white' : 'hover:bg-slate-100' }}">বাং</a>
            </div>
            <div>
                <a href="/" class="flex items-center justify-center">
                    <span class="flex h-16 w-44 items-center justify-center overflow-hidden rounded-2xl bg-white/70 p-2 shadow-sm ring-1 ring-slate-200">
                        <img src="{{ asset('1772777966111~3.png') }}" alt="RAW VIBE ツ" class="h-full w-full scale-105 object-cover object-center">
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white shadow-lg ring-1 ring-slate-100 overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
