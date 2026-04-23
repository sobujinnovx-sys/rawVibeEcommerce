<footer class="bg-slate-900 text-slate-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-white font-bold text-sm">RV</span>
                <span class="text-xl font-semibold text-white">RAW VIBE ツ</span>
            </div>
            <p class="text-sm text-slate-400">Your modern ecommerce destination for quality products, delivered fast.</p>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-white mb-3">Shop</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('shop.index') }}" class="hover:text-white">All Products</a></li>
                <li><a href="{{ route('shop.index', ['category' => '']) }}" class="hover:text-white">Categories</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-white mb-3">Account</h4>
            <ul class="space-y-2 text-sm">
                @auth
                    <li><a href="{{ route('dashboard') }}" class="hover:text-white">My Orders</a></li>
                    <li><a href="{{ route('wishlist.index') }}" class="hover:text-white">Wishlist</a></li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white">Register</a></li>
                @endauth
            </ul>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-white mb-3">Support</h4>
            <ul class="space-y-2 text-sm">
                <li>Email: support@rawvibe.test</li>
                <li>Cash on Delivery Available</li>
            </ul>
        </div>
    </div>
    <div class="border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 py-5 text-xs text-slate-500 flex flex-col sm:flex-row justify-between gap-2">
            <span>&copy; {{ date('Y') }} RAW VIBE ツ. All rights reserved.</span>
            <span>Developed by <span class="text-slate-300 font-medium">Amith Hassan Anik</span> · Laravel + Blade + Tailwind</span>
        </div>
    </div>
</footer>
