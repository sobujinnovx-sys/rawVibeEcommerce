@extends('layouts.storefront')

@section('title', __('Wishlist').' — RAW VIBE ツ')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold text-slate-900 mb-8">{{ __('My Wishlist') }}</h1>

        @if ($wishlistItems->isEmpty())
            <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-16 text-center">
                <p class="text-slate-500 mb-4">{{ __('Your wishlist is empty.') }}</p>
                <a href="{{ route('shop.index') }}" class="inline-flex bg-indigo-600 text-white px-5 py-3 rounded-full font-semibold hover:bg-indigo-500">{{ __('Shop Now') }}</a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($wishlistItems as $wishlist)
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
                        <a href="{{ route('shop.show', $wishlist->product) }}" class="block aspect-square bg-slate-100">
                            @if ($wishlist->product->image)
                                <img src="{{ asset('storage/'.$wishlist->product->image) }}" alt="{{ $wishlist->product->name }}" class="w-full h-full object-cover">
                            @endif
                        </a>
                        <div class="p-4">
                            <a href="{{ route('shop.show', $wishlist->product) }}" class="font-semibold text-slate-900 line-clamp-1">{{ $wishlist->product->name }}</a>
                            <p class="text-sm text-slate-500">${{ number_format((float) $wishlist->product->price, 2) }}</p>
                            <div class="mt-3 flex gap-2">
                                <form method="POST" action="{{ route('cart.store', $wishlist->product) }}" class="flex-1">
                                    @csrf
                                    <button class="w-full text-xs font-semibold bg-indigo-600 text-white rounded-full py-2 hover:bg-indigo-500">{{ __('Add to Cart') }}</button>
                                </form>
                                <form method="POST" action="{{ route('wishlist.destroy', $wishlist) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs font-semibold border border-slate-200 rounded-full px-3 py-2 text-slate-600 hover:bg-slate-50">{{ __('Remove') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $wishlistItems->links() }}</div>
        @endif
    </div>
@endsection
