@extends('layouts.storefront')

@section('title', __('Shop').' — RAW VIBE ツ')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">{{ __('All Products') }}</h1>
                <p class="text-sm text-slate-500">{{ __('Explore our full catalog.') }}</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-[260px_1fr] gap-8">
            <aside class="bg-white rounded-2xl border border-slate-200 p-6 h-max">
                <form method="GET" action="{{ route('shop.index') }}" class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Search') }}</label>
                        <input type="search" name="search" value="{{ $search }}" placeholder="{{ __('Find products...') }}"
                               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Category') }}</label>
                        <div class="space-y-2 text-sm">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="category" value="" @checked($selectedCategory === '')
                                       class="text-indigo-600 focus:ring-indigo-500">
                                <span>{{ __('All Categories') }}</span>
                            </label>
                            @foreach ($categories as $category)
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="category" value="{{ $category->slug }}"
                                           @checked($selectedCategory === $category->slug)
                                           class="text-indigo-600 focus:ring-indigo-500">
                                    <span>{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-indigo-600 text-white rounded-full py-2 text-sm font-semibold hover:bg-indigo-500">{{ __('Apply') }}</button>
                        <a href="{{ route('shop.index') }}" class="flex-1 text-center border border-slate-200 rounded-full py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">{{ __('Reset') }}</a>
                    </div>
                </form>
            </aside>

            <div>
                @if ($products->isEmpty())
                    <div class="rounded-2xl bg-white border border-dashed border-slate-300 p-10 text-center text-slate-500">
                        {{ __('No products match your filters.') }}
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    <div class="mt-8">{{ $products->links() }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection
