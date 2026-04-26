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
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-xl bg-white ring-1 ring-slate-200">
                        <img src="{{ asset('1772777966111~3.png') }}" alt="RAW VIBE ツ" width="48" height="48" style="max-width:48px;max-height:48px" class="h-12 w-12 object-cover object-center">
                    </span>
                    <span class="text-sm font-semibold text-white">{{ __('Admin Panel') }}</span>
                </a>
            </div>
            <nav class="p-4 space-y-1 text-sm">
                @php
                    $links = [
                        ['admin.dashboard', __('Dashboard')],
                        ['admin.carousel-banners.index', __('Carousel Banners')],
                        ['admin.categories.index', __('Categories')],
                        ['admin.coupons.index', __('Coupons')],
                        ['admin.products.index', __('Products')],
                        ['admin.orders.index', __('Orders')],
                        ['admin.users.index', __('Users')],
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
                <a href="{{ route('home') }}" class="block text-xs text-slate-400 hover:text-white">&larr; {{ __('Back to Storefront') }}</a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between">
                <button class="lg:hidden text-slate-600" @click="sidebar = !sidebar">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-semibold text-slate-900">@yield('page_title', __('Dashboard'))</h1>
                <div class="flex items-center gap-3 text-sm">
                    <div class="hidden sm:flex items-center gap-1 rounded-full border border-slate-200 p-1 text-xs font-semibold text-slate-600">
                        <a href="{{ route('locale.switch', 'en') }}" class="rounded-full px-2 py-1 {{ app()->currentLocale() === 'en' ? 'bg-slate-900 text-white' : 'hover:bg-slate-100' }}">EN</a>
                        <a href="{{ route('locale.switch', 'bn') }}" class="rounded-full px-2 py-1 {{ app()->currentLocale() === 'bn' ? 'bg-slate-900 text-white' : 'hover:bg-slate-100' }}">বাং</a>
                    </div>
                    <span class="text-slate-600 hidden sm:inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-rose-600 font-semibold hover:text-rose-500">{{ __('Log Out') }}</button>
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
                &copy; {{ date('Y') }} RAW VIBE ツ · {{ __('Developed by') }} <span class="font-medium text-slate-700">Amith Hassan Anik</span>
            </footer>
        </div>
    </div>
</body>
</html>
