<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-800">
    <div class="min-h-screen flex" x-data="{ sidebar: false }">
        <aside :class="sidebar ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 w-64 bg-slate-900 text-slate-200 transform lg:translate-x-0 lg:static transition-transform z-30">
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-white font-bold text-sm mr-2">RV</span>
                <span class="font-semibold text-white">RAW VIBE ツ Admin</span>
            </div>
            <nav class="p-4 space-y-1 text-sm">
                @php
                    $links = [
                        ['admin.dashboard', 'Dashboard'],
                        ['admin.categories.index', 'Categories'],
                        ['admin.products.index', 'Products'],
                        ['admin.orders.index', 'Orders'],
                        ['admin.users.index', 'Users'],
                    ];
                @endphp
                @foreach ($links as [$route, $label])
                    <a href="{{ route($route) }}"
                       class="flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs($route.'*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800' }}">
                        <span class="h-2 w-2 rounded-full bg-indigo-400"></span>
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
            <div class="absolute bottom-0 inset-x-0 p-4 border-t border-slate-800">
                <a href="{{ route('home') }}" class="block text-xs text-slate-400 hover:text-white">← Back to Storefront</a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between">
                <button class="lg:hidden text-slate-600" @click="sidebar = !sidebar">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-semibold text-slate-900">@yield('page_title', 'Dashboard')</h1>
                <div class="flex items-center gap-3 text-sm">
                    <span class="text-slate-600 hidden sm:inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-rose-600 font-semibold hover:text-rose-500">Logout</button>
                    </form>
                </div>
            </header>

            @if (session('success'))
                <div class="bg-emerald-50 border-b border-emerald-200 text-emerald-700 px-6 py-2 text-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-rose-50 border-b border-rose-200 text-rose-700 px-6 py-2 text-sm">{{ session('error') }}</div>
            @endif

            <main class="p-6 flex-1">
                @yield('content')
            </main>

            <footer class="px-6 py-4 text-xs text-slate-500 border-t border-slate-200 bg-white">
                &copy; {{ date('Y') }} RAW VIBE ツ · Developed by <span class="font-medium text-slate-700">Amith Hassan Anik</span>
            </footer>
        </div>
    </div>
</body>
</html>
