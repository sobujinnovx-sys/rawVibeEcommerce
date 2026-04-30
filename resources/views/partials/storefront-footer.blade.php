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
                <li>
                    <a href="https://wa.me/8801961627102" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 hover:text-white">
                        <svg class="h-4 w-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span>01961627102</span>
                    </a>
                </li>
                <li>
                    <a href="https://www.facebook.com/share/1A5RC56BVs/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 hover:text-white">
                        <svg class="h-4 w-4 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span>Facebook Page</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 py-5 text-xs text-slate-500 flex flex-col sm:flex-row justify-between gap-2">
            <span>&copy; {{ date('Y') }} RAW VIBE ツ. {{ __('All rights reserved.') }}</span>
            <span>{{ __('Developed by') }} <span class="text-slate-300 font-medium">Amith Hassan Anik</span> · Laravel + Blade </span>
        </div>
    </div>
</footer>
