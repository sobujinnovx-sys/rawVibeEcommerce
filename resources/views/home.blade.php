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
            ])->values()->toArray();
        @endphp

        <section
            x-data="infiniteCarousel()"
            x-init="init(@js($slides))"
            class="relative overflow-hidden bg-gradient-to-br from-cyan-600 via-sky-700 to-indigo-800 text-white"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 grid md:grid-cols-2 gap-10 items-center">
                <!-- Text Content -->
                <div>
                    <span class="inline-flex items-center gap-2 bg-white/10 text-white/90 text-xs uppercase tracking-widest px-3 py-1 rounded-full">
                        {{ __('PROMOTIONAL BANNER') }}
                    </span>

                    <div class="mt-4 overflow-hidden">
                        <div
                            class="whitespace-nowrap"
                            x-ref="textContainer"
                            :style="`transform: translateX(-${currentIndex * 100}%); transition: transform ${transitionDuration}ms ease-in-out;`"
                        >
                            <template x-for="(slide, idx) in slides" :key="idx">
                                <div class="inline-block w-full align-top" style="width: 100%;">
                                    <h1 class="text-4xl md:text-5xl font-bold leading-tight whitespace-normal" x-text="slide.title"></h1>
                                    <p class="mt-4 text-white/80 max-w-lg whitespace-normal" x-text="slide.subtitle || '{{ __('Exclusive offers and fresh arrivals waiting for you.') }}'"></p>
                                    <div class="mt-6 flex flex-wrap gap-3 whitespace-normal">
                                        <a :href="slide.button_link" class="inline-flex items-center gap-2 bg-white text-indigo-700 font-semibold px-5 py-3 rounded-full hover:bg-slate-100 transition" x-text="slide.button_text"></a>
                                        <a href="#featured" class="inline-flex items-center gap-2 border border-white/40 text-white font-semibold px-5 py-3 rounded-full hover:bg-white/10 transition">
                                            {{ __('Explore Featured') }}
                                        </a>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Dots Navigation -->
                    <div class="mt-6 flex gap-2">
                        <template x-for="(_, idx) in slides" :key="idx">
                            <button
                                @click="goToSlide(idx)"
                                class="h-2.5 rounded-full transition-all duration-300"
                                :class="currentIndex === idx ? 'w-8 bg-white' : 'w-2.5 bg-white/50 hover:bg-white/70'"
                            ></button>
                        </template>
                    </div>
                </div>

                <!-- Image Carousel -->
                <div class="relative order-first md:order-none">
                    <div class="aspect-[16/10] md:aspect-[4/3] rounded-3xl bg-white/10 backdrop-blur p-4 md:p-6">
                        <div class="w-full h-full rounded-2xl overflow-hidden relative">
                            <div
                                class="h-full flex"
                                x-ref="imageContainer"
                                :style="`transform: translateX(-${currentIndex * 100}%); transition: transform ${transitionDuration}ms ease-in-out;`"
                            >
                                <template x-for="(slide, idx) in slides" :key="idx">
                                    <div class="relative flex-shrink-0 w-full h-full">
                                        <div class="absolute inset-0 rounded-2xl border border-white/30 bg-white/10 overflow-hidden">
                                            <template x-if="slide.image_url">
                                                <img :src="slide.image_url" :alt="slide.title" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!slide.image_url">
                                                <div class="w-full h-full bg-gradient-to-br from-white/35 via-white/20 to-transparent"></div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            function infiniteCarousel() {
                return {
                    slides: [],
                    currentIndex: 0,
                    timer: null,
                    transitionDuration: 600,
                    isTransitioning: false,

                    init(slidesData) {
                        this.slides = slidesData;
                        this.currentIndex = 0;
                        this.startAutoPlay();
                    },

                    nextSlide() {
                        if (this.isTransitioning) return;

                        this.isTransitioning = true;

                        // Move to next slide
                        let nextIndex = this.currentIndex + 1;

                        if (nextIndex >= this.slides.length) {
                            // At the end, go back to first slide
                            // First, jump without animation to a cloned version
                            this.jumpToSlideWithoutAnimation(0);
                            this.currentIndex = 0;

                            // Then after a tiny delay, animate to actual first slide
                            setTimeout(() => {
                                this.animateToSlide(0);
                                setTimeout(() => {
                                    this.isTransitioning = false;
                                }, this.transitionDuration);
                            }, 50);
                        } else {
                            this.animateToSlide(nextIndex);
                            this.currentIndex = nextIndex;

                            setTimeout(() => {
                                this.isTransitioning = false;
                            }, this.transitionDuration);
                        }
                    },

                    animateToSlide(index) {
                        // Apply transition and move to slide
                        const textContainer = this.$refs.textContainer;
                        const imageContainer = this.$refs.imageContainer;

                        if (textContainer) {
                            textContainer.style.transition = `transform ${this.transitionDuration}ms ease-in-out`;
                            textContainer.style.transform = `translateX(-${index * 100}%)`;
                        }

                        if (imageContainer) {
                            imageContainer.style.transition = `transform ${this.transitionDuration}ms ease-in-out`;
                            imageContainer.style.transform = `translateX(-${index * 100}%)`;
                        }
                    },

                    jumpToSlideWithoutAnimation(index) {
                        // Jump instantly without transition
                        const textContainer = this.$refs.textContainer;
                        const imageContainer = this.$refs.imageContainer;

                        if (textContainer) {
                            textContainer.style.transition = 'none';
                            textContainer.style.transform = `translateX(-${index * 100}%)`;
                        }

                        if (imageContainer) {
                            imageContainer.style.transition = 'none';
                            imageContainer.style.transform = `translateX(-${index * 100}%)`;
                        }

                        // Force reflow to ensure transition is removed
                        if (textContainer) void textContainer.offsetHeight;
                        if (imageContainer) void imageContainer.offsetHeight;
                    },

                    goToSlide(index) {
                        if (this.isTransitioning || index === this.currentIndex) return;

                        this.isTransitioning = true;
                        this.animateToSlide(index);
                        this.currentIndex = index;

                        // Reset auto-play
                        this.resetAutoPlay();

                        setTimeout(() => {
                            this.isTransitioning = false;
                        }, this.transitionDuration);
                    },

                    startAutoPlay() {
                        if (this.timer) clearInterval(this.timer);
                        this.timer = setInterval(() => {
                            this.nextSlide();
                        }, 4200);
                    },

                    resetAutoPlay() {
                        if (this.timer) clearInterval(this.timer);
                        this.startAutoPlay();
                    }
                }
            }
        </script>
    @else
        <!-- Fallback banner -->
        <section class="relative overflow-hidden bg-gradient-to-br from-cyan-600 via-sky-700 to-indigo-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <span class="inline-flex items-center gap-2 bg-white/10 text-white/90 text-xs uppercase tracking-widest px-3 py-1 rounded-full">
                        {{ __('PROMOTIONAL BANNER') }}
                    </span>
                    <h1 class="mt-4 text-4xl md:text-5xl font-bold leading-tight">
                        {{ __('UNLOCK || YOUR || STYLE WITH') }}<br>{{ __('RAW VIBE') }} ❤️
                    </h1>
                    <p class="mt-4 text-white/80 max-w-lg">
                        {{ __('Up to 10% off on selected products - limited time offer.') }}
                    </p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-white text-indigo-700 font-semibold px-5 py-3 rounded-full hover:bg-slate-100 transition">
                            {{ __('Shop now') }}
                        </a>
                        <a href="#featured" class="inline-flex items-center gap-2 border border-white/40 text-white font-semibold px-5 py-3 rounded-full hover:bg-white/10 transition">
                            {{ __('Explore Featured') }}
                        </a>
                    </div>
                </div>
                <div class="relative order-first md:order-none">
                    <div class="aspect-[16/10] md:aspect-[4/3] rounded-3xl bg-white/10 backdrop-blur p-4 md:p-6">
                        <div class="w-full h-full rounded-2xl bg-gradient-to-br from-white/35 via-white/10 to-transparent border border-white/30"></div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Categories Section -->
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

    <!-- Featured Products Section -->
    <section id="featured" x-data class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-end justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">{{ __('Featured Products') }}</h2>
                <p class="text-sm text-slate-500">{{ __('Hand-picked items you will love.') }}</p>
            </div>
            <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">{{ __('Shop all') }} &rarr;</a>
        </div>
        @if ($featuredProducts->isEmpty())
            <div class="rounded-2xl bg-white border border-dashed border-slate-300 p-10 text-center text-slate-500">
                {{ __('No featured products yet. Check back soon!') }}
            </div>
        @else
            <div class="relative group">
                <button type="button" @click="$refs.featuredSlider.scrollBy({ left: -320, behavior: 'smooth' })" class="absolute -left-6 top-1/2 -translate-y-1/2 z-10 rounded-full border border-slate-300 bg-indigo-600 text-white p-4 hover:bg-indigo-700 hover:border-indigo-600 transition shadow-md opacity-0 group-hover:opacity-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" @click="$refs.featuredSlider.scrollBy({ left: 320, behavior: 'smooth' })" class="absolute -right-6 top-1/2 -translate-y-1/2 z-10 rounded-full border border-slate-300 bg-indigo-600 text-white p-4 hover:bg-indigo-700 hover:border-indigo-600 transition shadow-md opacity-0 group-hover:opacity-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <div x-ref="featuredSlider" class="flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        [x-ref="featuredSlider"]::-webkit-scrollbar {
                            display: none;
                        }
                    </style>
                    @foreach ($featuredProducts as $product)
                        <div class="min-w-[250px] sm:min-w-[280px] md:min-w-[320px] snap-start">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    <!-- Latest Arrivals Section -->
    <section x-data class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-end justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">{{ __('Latest Arrivals') }}</h2>
                <p class="text-sm text-slate-500">{{ __('Fresh picks added this week.') }}</p>
            </div>
        </div>
        @if ($latestProducts->isEmpty())
            <div class="rounded-2xl bg-white border border-dashed border-slate-300 p-10 text-center text-slate-500">
                {{ __('No products available yet.') }}
            </div>
        @else
            <div class="relative group">
                <button type="button" @click="$refs.latestSlider.scrollBy({ left: -320, behavior: 'smooth' })" class="absolute -left-6 top-1/2 -translate-y-1/2 z-10 rounded-full border border-slate-300 bg-indigo-600 text-white p-4 hover:bg-indigo-700 hover:border-indigo-600 transition shadow-md opacity-0 group-hover:opacity-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" @click="$refs.latestSlider.scrollBy({ left: 320, behavior: 'smooth' })" class="absolute -right-6 top-1/2 -translate-y-1/2 z-10 rounded-full border border-slate-300 bg-indigo-600 text-white p-4 hover:bg-indigo-700 hover:border-indigo-600 transition shadow-md opacity-0 group-hover:opacity-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <div x-ref="latestSlider" class="flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        [x-ref="latestSlider"]::-webkit-scrollbar {
                            display: none;
                        }
                    </style>
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
