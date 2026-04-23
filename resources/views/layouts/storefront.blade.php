<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'RAW VIBE ツ'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">
    <div class="min-h-screen flex flex-col">
        @include('partials.storefront-navbar')

        @if (session('success'))
            <div class="bg-emerald-50 border-b border-emerald-200 text-emerald-700">
                <div class="max-w-7xl mx-auto px-4 py-3 text-sm">{{ session('success') }}</div>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-rose-50 border-b border-rose-200 text-rose-700">
                <div class="max-w-7xl mx-auto px-4 py-3 text-sm">{{ session('error') }}</div>
            </div>
        @endif

        <main class="flex-1">
            @yield('content')
        </main>

        @include('partials.storefront-footer')
    </div>
</body>
</html>
