@extends('layouts.storefront')

@section('title', __('Checkout').' — RAW VIBE ツ')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold text-slate-900 mb-8">{{ __('Checkout') }}</h1>

        <form method="POST" action="{{ route('checkout.store') }}" class="grid lg:grid-cols-[1fr_360px] gap-8">
            @csrf

            <div class="space-y-6">
                <div class="bg-white border border-slate-200 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">{{ __('Shipping Information') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Full Name') }}</label>
                            <input name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required
                                   class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('shipping_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Email') }}</label>
                            <input type="email" name="shipping_email" value="{{ old('shipping_email', auth()->user()->email) }}" required
                                   class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('shipping_email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Phone') }}</label>
                            <input name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" required
                                   class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('shipping_phone') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('City') }}</label>
                            <input name="shipping_city" value="{{ old('shipping_city') }}" required
                                   class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('shipping_city') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Street Address') }}</label>
                            <input name="shipping_address" value="{{ old('shipping_address') }}" required
                                   class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            @error('shipping_address') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Postal Code') }}</label>
                            <input name="shipping_postal_code" value="{{ old('shipping_postal_code') }}"
                                   class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Order Notes') }}</label>
                            <textarea name="notes" rows="3"
                                      class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">{{ __('Payment Method') }}</h2>
                    <label class="flex items-start gap-3 border border-slate-200 rounded-xl p-4 cursor-pointer hover:border-indigo-400">
                        <input type="radio" name="payment_method" value="cod" checked class="mt-1 text-indigo-600">
                        <div>
                            <span class="font-medium text-slate-900 block">{{ __('Cash on Delivery') }}</span>
                            <span class="text-sm text-slate-500">{{ __('Pay with cash when your order arrives.') }}</span>
                        </div>
                    </label>
                    <p class="text-xs text-slate-500 mt-3">{{ __('More payment gateways (SSLCommerz, bKash) coming soon.') }}</p>
                </div>
            </div>

            <aside class="bg-white border border-slate-200 rounded-2xl p-6 h-max">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">{{ __('Order Summary') }}</h2>
                <ul class="divide-y text-sm">
                    @foreach ($cartItems as $item)
                        <li class="py-2 flex justify-between gap-3">
                            <div>
                                <span class="text-slate-700">{{ $item->product->name }} × {{ $item->quantity }}</span>
                                @if ($item->product->has_discount)
                                    <p class="text-xs text-slate-400"><del>৳{{ number_format((float) $item->product->price, 2) }}</del></p>
                                @endif
                            </div>
                            <div class="text-right">
                                @if ($item->product->has_discount)
                                    <div class="font-medium text-rose-600">৳{{ number_format($item->quantity * (float) $item->product->effective_price, 2) }}</div>
                                @else
                                    <div class="font-medium">৳{{ number_format($item->quantity * (float) $item->product->effective_price, 2) }}</div>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">{{ __('Coupon Code') }}</label>
                    <div class="flex gap-2">
                        <input name="coupon_code" value="{{ old('coupon_code', $coupon?->code) }}" placeholder="SAVE10"
                               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm uppercase">
                        <button type="submit" formaction="{{ route('checkout.coupon.apply') }}" formnovalidate
                                class="shrink-0 rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-indigo-300 hover:text-indigo-600">
                            {{ __('Apply') }}
                        </button>
                    </div>
                    @error('coupon_code') <p class="text-xs text-rose-500 mt-2">{{ $message }}</p> @enderror
                    @if ($coupon)
                        <div class="mt-3 flex items-center justify-between gap-3 rounded-xl bg-emerald-50 px-3 py-2 text-sm text-emerald-700">
                            <span>{{ __('Applied coupon') }}: <strong>{{ $coupon->code }}</strong></span>
                            <button type="submit" formaction="{{ route('checkout.coupon.remove') }}" formnovalidate
                                    class="font-semibold text-emerald-700 hover:text-emerald-600">
                                {{ __('Remove') }}
                            </button>
                        </div>
                    @endif
                </div>
                <dl class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><dt>{{ __('Subtotal') }}</dt><dd>৳{{ number_format($subtotal, 2) }}</dd></div>
                    @if ($couponDiscount > 0)
                        <div class="flex justify-between text-emerald-600"><dt>{{ __('Coupon Discount') }}</dt><dd>-৳{{ number_format($couponDiscount, 2) }}</dd></div>
                    @endif
                    <div class="flex justify-between"><dt>{{ __('Shipping') }}</dt><dd>৳{{ number_format($shippingCost, 2) }}</dd></div>
                </dl>
                <div class="mt-3 pt-3 border-t flex justify-between text-base font-bold text-slate-900">
                    <span>{{ __('Total') }}</span>
                    <span>৳{{ number_format($total, 2) }}</span>
                </div>
                <button type="submit" class="mt-6 w-full bg-indigo-600 text-white font-semibold rounded-full py-3 hover:bg-indigo-500">
                    {{ __('Place Order') }}
                </button>
            </aside>
        </form>
    </div>
@endsection
