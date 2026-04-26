@extends('layouts.storefront')

@section('title', $product->name.' — RAW VIBE ツ')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <nav class="text-sm text-slate-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">{{ __('Home') }}</a> /
            <a href="{{ route('shop.index') }}" class="hover:text-indigo-600">{{ __('Shop') }}</a> /
            <span class="text-slate-700">{{ $product->name }}</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-10 bg-white border border-slate-200 rounded-3xl p-6 md:p-10">
            <div class="aspect-square bg-slate-100 rounded-2xl overflow-hidden">
                @if ($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                        <svg class="h-24 w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
                    </div>
                @endif
            </div>

            <div class="flex flex-col">
                <span class="text-xs uppercase tracking-widest text-indigo-600">{{ $product->category?->name }}</span>
                <h1 class="text-3xl font-bold text-slate-900 mt-2">{{ $product->name }}</h1>
                @if ($product->has_discount)
                    <div class="mt-2 inline-flex w-fit items-center gap-2 rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-600">
                        <span>-{{ $product->discount_percentage }}%</span>
                        @if (!empty($product->promo_label))
                            <span>• {{ $product->promo_label }}</span>
                        @endif
                    </div>
                @elseif (!empty($product->promo_label))
                    <div class="mt-2 inline-flex w-fit items-center rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                        {{ $product->promo_label }}
                    </div>
                @endif
                <div class="mt-4 flex items-baseline gap-3">
                    @if ($product->has_discount)
                        <span class="text-3xl font-semibold text-rose-600">৳{{ number_format((float) $product->effective_price, 2) }}</span>
                        <span class="text-lg text-slate-400 line-through">৳{{ number_format((float) $product->price, 2) }}</span>
                    @else
                        <span class="text-3xl font-semibold text-slate-900">৳{{ number_format((float) $product->price, 2) }}</span>
                    @endif
                    @if ($product->stock > 0)
                        <span class="text-sm text-emerald-600 font-medium">{{ __('In Stock') }} ({{ $product->stock }})</span>
                    @else
                        <span class="text-sm text-rose-600 font-medium">{{ __('Out of Stock') }}</span>
                    @endif
                </div>
                <p class="mt-5 text-slate-600 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>

                <div class="mt-8 flex flex-wrap gap-3">
                    @auth
                        @if (!auth()->user()->isAdmin())
                            <form method="POST" action="{{ route('cart.store', $product) }}">
                                @csrf
                                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-indigo-500 disabled:opacity-60"
                                    @disabled($product->stock < 1)>
                                    {{ $product->stock > 0 ? __('Add to Cart') : __('Out of Stock') }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('wishlist.store', $product) }}">
                                @csrf
                                <button type="submit" class="border border-slate-200 text-slate-700 px-6 py-3 rounded-full font-semibold hover:bg-slate-50">
                                    ♡ {{ __('Add to Wishlist') }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('admin.dashboard') }}" class="border border-slate-200 text-slate-700 px-6 py-3 rounded-full font-semibold hover:bg-slate-50">
                                {{ __('Open Admin Panel') }}
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-indigo-500">{{ __('Login to Buy') }}</a>
                    @endauth
                </div>

                <div class="mt-10 grid grid-cols-3 gap-3 text-sm">
                    <div class="rounded-xl bg-slate-50 p-3"><strong class="block text-slate-800">{{ __('Fast Delivery') }}</strong><span class="text-slate-500">{{ __('2-5 business days') }}</span></div>
                    <div class="rounded-xl bg-slate-50 p-3"><strong class="block text-slate-800">{{ __('Secure Checkout') }}</strong><span class="text-slate-500">{{ __('SSL protected') }}</span></div>
                    <div class="rounded-xl bg-slate-50 p-3"><strong class="block text-slate-800">{{ __('COD Available') }}</strong><span class="text-slate-500">{{ __('Pay on delivery') }}</span></div>
                </div>
            </div>
        </div>

        <section class="mt-14 grid gap-8 lg:grid-cols-[1.15fr_0.85fr]">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 md:p-8">
                @php
                    $averageRating = round((float) $product->reviews->avg('rating'), 1);
                    $reviewCount = $product->reviews->count();
                    $existingReview = auth()->check() ? $product->reviews->firstWhere('user_id', auth()->id()) : null;
                @endphp

                <div class="flex flex-col gap-3 border-b border-slate-100 pb-6 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">{{ __('Customer Reviews') }}</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            @if ($reviewCount > 0)
                                {{ __('Average rating') }}: <span class="font-semibold text-slate-900">{{ number_format($averageRating, 1) }}/5</span>
                                <span class="text-slate-400">({{ trans_choice('{1} :count review|[2,*] :count reviews', $reviewCount, ['count' => $reviewCount]) }})</span>
                            @else
                                {{ __('No reviews yet.') }}
                            @endif
                        </p>
                    </div>
                    @if ($reviewCount > 0)
                        <div class="text-amber-500 text-xl tracking-[0.2em]">
                            {{ str_repeat('★', (int) round($averageRating)) }}{{ str_repeat('☆', max(0, 5 - (int) round($averageRating))) }}
                        </div>
                    @endif
                </div>

                <div class="mt-6 space-y-4">
                    @forelse ($product->reviews as $review)
                        <article class="rounded-2xl border border-slate-200 p-4">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-semibold text-slate-900">{{ $review->title ?: __('Verified customer review') }}</h3>
                                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">{{ $review->user->name }}</span>
                                    </div>
                                    <div class="mt-1 text-sm text-amber-500">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</div>
                                </div>
                                <span class="text-xs text-slate-400">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-slate-600 whitespace-pre-line">{{ $review->comment }}</p>
                        </article>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-slate-500">
                            {{ __('No reviews yet.') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 md:p-8">
                <h2 class="text-2xl font-bold text-slate-900">{{ $existingReview ? __('Update your review') : __('Write a review') }}</h2>
                @auth
                    @if ($canReview)
                        <form method="POST" action="{{ route('products.reviews.store', $product) }}" class="mt-6 space-y-5">
                            @csrf
                            <div>
                                <label for="rating" class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Rating') }}</label>
                                <select id="rating" name="rating" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                                    @for ($rating = 5; $rating >= 1; $rating--)
                                        <option value="{{ $rating }}" @selected((int) old('rating', $existingReview?->rating ?? 5) === $rating)>
                                            {{ trans_choice('{1} :count star|[2,*] :count stars', $rating, ['count' => $rating]) }}
                                        </option>
                                    @endfor
                                </select>
                                @error('rating') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Title') }}</label>
                                <input id="title" name="title" type="text" value="{{ old('title', $existingReview?->title) }}"
                                       placeholder="{{ __('Summarize your experience') }}"
                                       class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                                @error('title') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="comment" class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Review') }}</label>
                                <textarea id="comment" name="comment" rows="5" required
                                          placeholder="{{ __('Tell other shoppers what you liked, how it fits, and how delivery went.') }}"
                                          class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">{{ old('comment', $existingReview?->comment) }}</textarea>
                                @error('comment') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" class="w-full rounded-full bg-indigo-600 px-5 py-3 font-semibold text-white hover:bg-indigo-500">
                                {{ $existingReview ? __('Update your review') : __('Submit review') }}
                            </button>
                        </form>
                    @else
                        <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-sm leading-6 text-slate-600">
                            {{ __('You can review this product after purchasing it.') }}
                        </div>
                    @endif
                @else
                    <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-sm leading-6 text-slate-600">
                        {{ __('Sign in to leave a review.') }}
                    </div>
                    <a href="{{ route('login') }}" class="mt-4 inline-flex rounded-full bg-indigo-600 px-5 py-3 font-semibold text-white hover:bg-indigo-500">{{ __('Login') }}</a>
                @endauth
            </div>
        </section>

        @if ($relatedProducts->isNotEmpty())
            <section class="mt-14">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">{{ __('Related Products') }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
