@extends('layouts.storefront')

@section('title', 'Your Cart — RAW VIBE ツ')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold text-slate-900 mb-8">Your Shopping Cart</h1>

        @if ($cartItems->isEmpty())
            <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-16 text-center">
                <p class="text-slate-500 mb-4">Your cart is empty.</p>
                <a href="{{ route('shop.index') }}" class="inline-flex bg-indigo-600 text-white px-5 py-3 rounded-full font-semibold hover:bg-indigo-500">Continue Shopping</a>
            </div>
        @else
            <div class="grid lg:grid-cols-[1fr_360px] gap-8">
                <div class="bg-white border border-slate-200 rounded-2xl divide-y">
                    @foreach ($cartItems as $item)
                        <div class="p-5 flex gap-4 items-center">
                            <div class="h-20 w-20 rounded-lg overflow-hidden bg-slate-100 flex-shrink-0">
                                @if ($item->product->image)
                                    <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('shop.show', $item->product) }}" class="font-semibold text-slate-900 hover:text-indigo-600 line-clamp-1">{{ $item->product->name }}</a>
                                <p class="text-sm text-slate-500">${{ number_format((float) $item->product->price, 2) }}</p>
                            </div>
                            <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                       class="w-20 rounded-lg border-slate-200 text-sm">
                                <button class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">Update</button>
                            </form>
                            <div class="w-24 text-right font-semibold text-slate-900">
                                ${{ number_format($item->quantity * (float) $item->product->price, 2) }}
                            </div>
                            <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-500 hover:text-rose-600" title="Remove">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <aside class="bg-white border border-slate-200 rounded-2xl p-6 h-max">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Order Summary</h2>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between"><dt>Subtotal</dt><dd class="font-semibold">${{ number_format($subtotal, 2) }}</dd></div>
                        <div class="flex justify-between text-slate-500"><dt>Shipping</dt><dd>Calculated at checkout</dd></div>
                    </dl>
                    <div class="mt-4 pt-4 border-t flex justify-between text-base">
                        <span class="font-semibold">Total</span>
                        <span class="font-bold text-slate-900">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}"
                       class="mt-6 block text-center bg-indigo-600 text-white font-semibold rounded-full py-3 hover:bg-indigo-500">
                        Proceed to Checkout
                    </a>
                    <a href="{{ route('shop.index') }}"
                       class="mt-3 block text-center text-sm text-slate-600 hover:text-indigo-600">Continue Shopping</a>
                </aside>
            </div>
        @endif
    </div>
@endsection
