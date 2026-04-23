@extends('layouts.storefront')

@section('title', 'RAW VIBE ツ — Shop the latest products')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid md:grid-cols-2 gap-10 items-center">
            <div>
                <span class="inline-flex items-center gap-2 bg-white/10 text-white/90 text-xs uppercase tracking-widest px-3 py-1 rounded-full">
                    New season collection
                </span>
                <h1 class="mt-4 text-4xl md:text-5xl font-bold leading-tight">
                    Shop smarter,<br>live better.
                </h1>
                <p class="mt-4 text-white/80 max-w-lg">
                    Discover curated products at unbeatable prices. Secure checkout, fast delivery, and Cash on Delivery support built for you.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-white text-indigo-700 font-semibold px-5 py-3 rounded-full hover:bg-slate-100">
                        Browse Products
                    </a>
                    <a href="#featured" class="inline-flex items-center gap-2 border border-white/40 text-white font-semibold px-5 py-3 rounded-full hover:bg-white/10">
                        Explore Featured
                    </a>
                </div>
            </div>
            <div class="relative hidden md:block">
                <div class="aspect-[4/3] rounded-3xl bg-white/10 backdrop-blur p-6">
                    <div class="grid grid-cols-2 gap-4 h-full">
                        <div class="bg-white/20 rounded-2xl"></div>
                        <div class="bg-white/30 rounded-2xl"></div>
                        <div class="bg-white/40 rounded-2xl col-span-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($categories->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Shop by Category</h2>
                    <p class="text-sm text-slate-500">Browse our most-loved collections.</p>
                </div>
                <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">View all →</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                       class="group rounded-2xl bg-white border border-slate-200 p-5 hover:border-indigo-300 hover:shadow-md transition">
                        <div class="h-12 w-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </div>
                        <h3 class="font-semibold text-slate-900 group-hover:text-indigo-600">{{ $category->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $category->products_count }} products</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section id="featured" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-end justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Featured Products</h2>
                <p class="text-sm text-slate-500">Hand-picked items you'll love.</p>
            </div>
            <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Shop all →</a>
        </div>
        @if ($featuredProducts->isEmpty())
            <div class="rounded-2xl bg-white border border-dashed border-slate-300 p-10 text-center text-slate-500">
                No featured products yet. Check back soon!
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-end justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Latest Arrivals</h2>
                <p class="text-sm text-slate-500">Fresh picks added this week.</p>
            </div>
        </div>
        @if ($latestProducts->isEmpty())
            <div class="rounded-2xl bg-white border border-dashed border-slate-300 p-10 text-center text-slate-500">
                No products available yet.
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($latestProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @endif
    </section>
@endsection
