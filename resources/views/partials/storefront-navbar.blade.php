@php
    $cartCount = auth()->check()
        ? auth()->user()->carts()->sum('quantity')
        : 0;
    $wishlistCount = auth()->check()
        ? auth()->user()->wishlistItems()->count()
        : 0;
@endphp

<header class="bg-white border-b border-slate-200 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-4">
            <a href="{{ route('home') }}" class="flex items-center">
                <span class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-xl bg-white ring-1 ring-slate-200">
                    <img src="{{ asset('1772777966111~3.png') }}" alt="RAW VIBE ツ" class="h-full w-full object-cover object-center">
                </span>
            </a>

            <form method="GET" action="{{ route('shop.index') }}" class="hidden md:flex flex-1 max-w-lg">
                <div class="relative w-full">
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="{{ __('Search products...') }}"
                        class="w-full rounded-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 pl-10 text-sm">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                    </svg>
                </div>
            </form>

            <nav class="flex items-center gap-4 text-sm">
                <div class="hidden sm:flex items-center gap-1 rounded-full border border-slate-200 p-1 text-xs font-semibold text-slate-600">
                    <a href="{{ route('locale.switch', 'en') }}" class="rounded-full px-2 py-1 {{ app()->currentLocale() === 'en' ? 'bg-slate-900 text-white' : 'hover:bg-slate-100' }}">EN</a>
                    <a href="{{ route('locale.switch', 'bn') }}" class="rounded-full px-2 py-1 {{ app()->currentLocale() === 'bn' ? 'bg-slate-900 text-white' : 'hover:bg-slate-100' }}">বাং</a>
                </div>
                <a href="{{ route('shop.index') }}" class="text-slate-600 hover:text-indigo-600 hidden sm:inline">{{ __('Shop') }}</a>

                @auth
                    <a href="{{ route('wishlist.index') }}" class="relative text-slate-600 hover:text-indigo-600">
                        <span class="hidden sm:inline">{{ __('Wishlist') }}</span>
                        @if ($wishlistCount)
                            <span class="absolute -top-2 -right-3 bg-rose-500 text-white text-xs rounded-full px-1.5">{{ $wishlistCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('cart.index') }}" class="relative text-slate-600 hover:text-indigo-600">
                        {{ __('Cart') }}
                        @if ($cartCount)
                            <span class="absolute -top-2 -right-3 bg-indigo-600 text-white text-xs rounded-full px-1.5">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-1 text-slate-700 hover:text-indigo-600">
                            {{ auth()->user()->name }}
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-slate-100 py-1" style="display: none;">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">{{ __('My Orders') }}</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">{{ __('Profile') }}</a>
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-indigo-600 hover:bg-slate-50">{{ __('Admin Panel') }}</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-slate-50">{{ __('Log Out') }}</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-500">{{ __('Register') }}</a>
                @endauth
            </nav>
        </div>

        <form method="GET" action="{{ route('shop.index') }}" class="md:hidden pb-3">
            <div class="mb-3 flex items-center justify-end gap-1 text-xs font-semibold text-slate-600">
                <a href="{{ route('locale.switch', 'en') }}" class="rounded-full border border-slate-200 px-2 py-1 {{ app()->currentLocale() === 'en' ? 'bg-slate-900 text-white border-slate-900' : 'hover:bg-slate-100' }}">EN</a>
                <a href="{{ route('locale.switch', 'bn') }}" class="rounded-full border border-slate-200 px-2 py-1 {{ app()->currentLocale() === 'bn' ? 'bg-slate-900 text-white border-slate-900' : 'hover:bg-slate-100' }}">বাং</a>
            </div>
            <div class="relative w-full">
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('Search products...') }}"
                    class="w-full rounded-full border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 pl-10 text-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                </svg>
            </div>
        </form>
    </div>
</header>
