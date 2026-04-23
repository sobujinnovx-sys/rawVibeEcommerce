@extends('layouts.storefront')

@section('title', $product->name.' — RAW VIBE ツ')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <nav class="text-sm text-slate-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a> /
            <a href="{{ route('shop.index') }}" class="hover:text-indigo-600">Shop</a> /
            <span class="text-slate-700">{{ $product->name }}</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-10 bg-white border border-slate-200 rounded-3xl p-6 md:p-10">
            <div class="aspect-square bg-slate-100 rounded-2xl overflow-hidden">
                @if ($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                        <svg class="h-24 w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
                    </div>
                @endif
            </div>

            <div class="flex flex-col">
                <span class="text-xs uppercase tracking-widest text-indigo-600">{{ $product->category?->name }}</span>
                <h1 class="text-3xl font-bold text-slate-900 mt-2">{{ $product->name }}</h1>
                <div class="mt-4 flex items-baseline gap-3">
                    <span class="text-3xl font-semibold text-slate-900">${{ number_format((float) $product->price, 2) }}</span>
                    @if ($product->stock > 0)
                        <span class="text-sm text-emerald-600 font-medium">In Stock ({{ $product->stock }})</span>
                    @else
                        <span class="text-sm text-rose-600 font-medium">Out of Stock</span>
                    @endif
                </div>
                <p class="mt-5 text-slate-600 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>

                <div class="mt-8 flex flex-wrap gap-3">
                    @auth
                        <form method="POST" action="{{ route('cart.store', $product) }}">
                            @csrf
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-indigo-500 disabled:opacity-60"
                                @disabled($product->stock < 1)>
                                {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('wishlist.store', $product) }}">
                            @csrf
                            <button type="submit" class="border border-slate-200 text-slate-700 px-6 py-3 rounded-full font-semibold hover:bg-slate-50">
                                ♡ Add to Wishlist
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-indigo-500">Login to Buy</a>
                    @endauth
                </div>

                <div class="mt-10 grid grid-cols-3 gap-3 text-sm">
                    <div class="rounded-xl bg-slate-50 p-3"><strong class="block text-slate-800">Fast Delivery</strong><span class="text-slate-500">2-5 business days</span></div>
                    <div class="rounded-xl bg-slate-50 p-3"><strong class="block text-slate-800">Secure Checkout</strong><span class="text-slate-500">SSL protected</span></div>
                    <div class="rounded-xl bg-slate-50 p-3"><strong class="block text-slate-800">COD Available</strong><span class="text-slate-500">Pay on delivery</span></div>
                </div>
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <section class="mt-14">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Related Products</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
