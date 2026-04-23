<footer class="bg-slate-900 text-slate-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
            <div class="mb-3 flex items-center gap-3">
                <span class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-xl bg-white ring-1 ring-slate-200">
                    <img src="{{ asset('1772777966111~3.png') }}" alt="RAW VIBE ツ" class="h-full w-full object-cover object-center">
                </span>
                <span class="text-lg font-semibold text-white">RAW VIBE ツ</span>
            </div>
            <p class="text-sm text-slate-400">{{ __('Your modern ecommerce destination for quality products, delivered fast.') }}</p>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-white mb-3">{{ __('Shop') }}</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('shop.index') }}" class="hover:text-white">{{ __('All Products') }}</a></li>
                <li><a href="{{ route('shop.index', ['category' => '']) }}" class="hover:text-white">{{ __('Categories') }}</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-white mb-3">{{ __('Account') }}</h4>
            <ul class="space-y-2 text-sm">
                @auth
                    <li><a href="{{ route('dashboard') }}" class="hover:text-white">{{ __('My Orders') }}</a></li>
                    <li><a href="{{ route('wishlist.index') }}" class="hover:text-white">{{ __('Wishlist') }}</a></li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-white">{{ __('Login') }}</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white">{{ __('Register') }}</a></li>
                @endauth
            </ul>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-white mb-3">{{ __('Support') }}</h4>
            <ul class="space-y-2 text-sm">
                <li>Email: ahanik2001@gmail.com</li>
                <li>{{ __('Cash on Delivery Available') }}</li>
            </ul>
        </div>
    </div>
    <div class="border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 py-5 text-xs text-slate-500 flex flex-col sm:flex-row justify-between gap-2">
            <span>&copy; {{ date('Y') }} RAW VIBE ツ. {{ __('All rights reserved.') }}</span>
            <span>{{ __('Developed by') }} <span class="text-slate-300 font-medium">Amith Hassan Anik</span> · Laravel + Blade + Tailwind</span>
        </div>
    </div>
</footer>
