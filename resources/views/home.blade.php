@extends('layouts.storefront')

@section('title', 'RAW VIBE ツ — '.__('Shop the latest products'))

@section('content')
    @if ($carouselBanners->isNotEmpty())
        @php
            $slides = $carouselBanners->map(fn ($banner) => [
                'title' => $banner->title,
                'subtitle' => $banner->subtitle,
                'button_text' => $banner->button_text ?: __('Shop now'),
                'button_link' => $banner->button_link ?: route('shop.index'),
                'image_url' => $banner->image_url,
            ])->values();
        @endphp
        <section x-data="{ active: 0, slides: @js($slides) }" x-init="setInterval(() => active = (active + 1) % slides.length, 4200)" class="relative overflow-hidden bg-gradient-to-br from-cyan-600 via-sky-700 to-indigo-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <span class="inline-flex items-center gap-2 bg-white/10 text-white/90 text-xs uppercase tracking-widest px-3 py-1 rounded-full">
                        {{ __('Promotional Banner') }}
                    </span>
                    <template x-for="(slide, idx) in slides" :key="idx">
                        <div x-show="active === idx" x-transition.opacity.duration.500ms>
                            <h1 class="mt-4 text-4xl md:text-5xl font-bold leading-tight" x-text="slide.title"></h1>
                            <p class="mt-4 text-white/80 max-w-lg" x-text="slide.subtitle || '{{ __('Exclusive offers and fresh arrivals waiting for you.') }}'"></p>
                            <div class="mt-6 flex flex-wrap gap-3">
                                <a :href="slide.button_link" class="inline-flex items-center gap-2 bg-white text-indigo-700 font-semibold px-5 py-3 rounded-full hover:bg-slate-100" x-text="slide.button_text"></a>
                                <a href="#featured" class="inline-flex items-center gap-2 border border-white/40 text-white font-semibold px-5 py-3 rounded-full hover:bg-white/10">
                                    {{ __('Explore Featured') }}
                                </a>
                            </div>
                        </div>
                    </template>
                    <div class="mt-6 flex gap-2">
                        <template x-for="(_, idx) in slides" :key="idx">
                            <button @click="active = idx" class="h-2.5 rounded-full transition-all" :class="active === idx ? 'w-8 bg-white' : 'w-2.5 bg-white/50'"></button>
                        </template>
                    </div>
                </div>
                <div class="relative order-first md:order-none">
                    <div class="aspect-[16/10] md:aspect-[4/3] rounded-3xl bg-white/10 backdrop-blur p-4 md:p-6 overflow-hidden">
                        <template x-for="(slide, idx) in slides" :key="idx">
                            <div x-show="active === idx" x-transition.opacity.duration.500ms class="absolute inset-4 md:inset-6 rounded-2xl border border-white/30 bg-white/10 overflow-hidden">
                                <template x-if="slide.image_url">
                                    <img :src="slide.image_url" :alt="slide.title" class="h-full w-full object-cover">
                                </template>
                                <template x-if="!slide.image_url">
                                    <div class="h-full w-full bg-gradient-to-br from-white/35 via-white/20 to-transparent"></div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="relative overflow-hidden bg-gradient-to-br from-cyan-600 via-sky-700 to-indigo-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <span class="inline-flex items-center gap-2 bg-white/10 text-white/90 text-xs uppercase tracking-widest px-3 py-1 rounded-full">
                        {{ __('New season collection') }}
                    </span>
                    <h1 class="mt-4 text-4xl md:text-5xl font-bold leading-tight">
                        {{ __('Shop smarter,') }}<br>{{ __('live better.') }}
                    </h1>
                    <p class="mt-4 text-white/80 max-w-lg">
                        {{ __('Discover curated products at unbeatable prices. Secure checkout, fast delivery, and Cash on Delivery support built for you.') }}
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-white text-indigo-700 font-semibold px-5 py-3 rounded-full hover:bg-slate-100">
                            {{ __('Browse Products') }}
                        </a>
                        <a href="#featured" class="inline-flex items-center gap-2 border border-white/40 text-white font-semibold px-5 py-3 rounded-full hover:bg-white/10">
                            {{ __('Explore Featured') }}
                        </a>
                    </div>
                </div>
                <div class="relative order-first md:order-none">
                    <div class="aspect-[16/10] md:aspect-[4/3] rounded-3xl bg-white/10 backdrop-blur p-4 md:p-6 overflow-hidden">
                        <div class="absolute inset-4 md:inset-6 rounded-2xl border border-white/30 bg-gradient-to-br from-white/35 via-white/10 to-transparent p-4 md:p-6">
                            <p class="text-xs uppercase tracking-[0.2em] text-white/75">{{ __('Promo') }}</p>
                            <h3 class="mt-3 text-3xl font-bold">{{ __('Flash Deal') }}</h3>
                            <p class="mt-3 text-white/80">{{ __('Experience a smoother checkout with trusted payment and fast delivery.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($categories->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="flex items-end justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">{{ __('Shop by Category') }}</h2>
                    <p class="text-sm text-slate-500">{{ __('Browse our most-loved collections.') }}</p>
                </div>
                <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">{{ __('View all') }} &rarr;</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                       class="group rounded-2xl bg-white border border-slate-200 p-5 hover:border-indigo-300 hover:shadow-md transition">
                        <div class="h-12 w-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </div>
                        <h3 class="font-semibold text-slate-900 group-hover:text-indigo-600">{{ $category->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ trans_choice('{1} :count product|[2,*] :count products', $category->products_count, ['count' => $category->products_count]) }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section id="featured" x-data class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-end justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">{{ __('Featured Products') }}</h2>
                <p class="text-sm text-slate-500">{{ __('Hand-picked items you will love.') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" @click="$refs.featuredSlider.scrollBy({ left: -320, behavior: 'smooth' })" class="rounded-full border border-slate-200 bg-white p-2 text-slate-600 hover:text-indigo-600 hover:border-indigo-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" @click="$refs.featuredSlider.scrollBy({ left: 320, behavior: 'smooth' })" class="rounded-full border border-slate-200 bg-white p-2 text-slate-600 hover:text-indigo-600 hover:border-indigo-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">{{ __('Shop all') }} &rarr;</a>
            </div>
        </div>
        @if ($featuredProducts->isEmpty())
            <div class="rounded-2xl bg-white border border-dashed border-slate-300 p-10 text-center text-slate-500">
                {{ __('No featured products yet. Check back soon!') }}
            </div>
        @else
            <div class="relative">
                <div x-ref="featuredSlider" class="flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @foreach ($featuredProducts as $product)
                    <div class="min-w-[250px] sm:min-w-[280px] md:min-w-[320px] snap-start">
                            <x-product-card :product="$product" />
                        </div>
                @endforeach
                </div>
            </div>
        @endif
    </section>

    <section x-data class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-end justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">{{ __('Latest Arrivals') }}</h2>
                <p class="text-sm text-slate-500">{{ __('Fresh picks added this week.') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" @click="$refs.latestSlider.scrollBy({ left: -320, behavior: 'smooth' })" class="rounded-full border border-slate-200 bg-white p-2 text-slate-600 hover:text-indigo-600 hover:border-indigo-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" @click="$refs.latestSlider.scrollBy({ left: 320, behavior: 'smooth' })" class="rounded-full border border-slate-200 bg-white p-2 text-slate-600 hover:text-indigo-600 hover:border-indigo-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
        @if ($latestProducts->isEmpty())
            <div class="rounded-2xl bg-white border border-dashed border-slate-300 p-10 text-center text-slate-500">
                {{ __('No products available yet.') }}
            </div>
        @else
            <div class="relative">
                <div x-ref="latestSlider" class="flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-2 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @foreach ($latestProducts as $product)
                    <div class="min-w-[250px] sm:min-w-[280px] md:min-w-[320px] snap-start">
                            <x-product-card :product="$product" />
                        </div>
                @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
