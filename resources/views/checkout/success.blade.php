@extends('layouts.storefront')

@section('title', __('Order Confirmed').' — RAW VIBE ツ')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 mb-6">
            <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h1 class="text-3xl font-bold text-slate-900">{{ __('Thank you for your order!') }}</h1>
        <p class="text-slate-600 mt-2">{{ __('Your order :order has been placed successfully.', ['order' => '#'.$order->order_number]) }}</p>

        <div class="mt-10 bg-white border border-slate-200 rounded-2xl p-6 text-left">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">{{ __('Order Details') }}</h2>
            <div class="grid md:grid-cols-2 gap-4 text-sm text-slate-600">
                <div><strong class="text-slate-900 block">{{ __('Payment Method') }}</strong>{{ strtoupper($order->payment_method) }}</div>
                <div><strong class="text-slate-900 block">{{ __('Status') }}</strong>{{ __(ucfirst($order->status)) }}</div>
                <div><strong class="text-slate-900 block">{{ __('Shipping To') }}</strong>{{ $order->shipping_name }} · {{ $order->shipping_phone }}</div>
                <div><strong class="text-slate-900 block">{{ __('Address') }}</strong>{{ $order->shipping_address }}, {{ $order->shipping_city }}</div>
            </div>

            <table class="w-full text-sm mt-6">
                <thead class="text-slate-500 text-left">
                    <tr><th class="py-2">{{ __('Product') }}</th><th class="py-2 text-right">{{ __('Qty') }}</th><th class="py-2 text-right">{{ __('Price') }}</th><th class="py-2 text-right">{{ __('Total') }}</th></tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($order->items as $item)
                        <tr><td class="py-2">{{ $item->product_name }}</td><td class="py-2 text-right">{{ $item->quantity }}</td><td class="py-2 text-right">৳{{ number_format((float) $item->price, 2) }}</td><td class="py-2 text-right">৳{{ number_format((float) $item->line_total, 2) }}</td></tr>
                    @endforeach
                </tbody>
            </table>

            <dl class="mt-4 space-y-1 text-sm text-right">
                <div class="flex justify-between md:justify-end md:gap-6"><dt>{{ __('Subtotal') }}</dt><dd>৳{{ number_format((float) $order->subtotal, 2) }}</dd></div>
                <div class="flex justify-between md:justify-end md:gap-6"><dt>{{ __('Shipping') }}</dt><dd>৳{{ number_format((float) $order->shipping_cost, 2) }}</dd></div>
                <div class="flex justify-between md:justify-end md:gap-6 text-base font-semibold text-slate-900"><dt>{{ __('Total') }}</dt><dd>৳{{ number_format((float) $order->total, 2) }}</dd></div>
            </dl>
        </div>

        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white px-5 py-3 rounded-full font-semibold hover:bg-indigo-500">{{ __('View My Orders') }}</a>
            <a href="{{ route('shop.index') }}" class="border border-slate-200 text-slate-700 px-5 py-3 rounded-full font-semibold hover:bg-slate-50">{{ __('Continue Shopping') }}</a>
        </div>
    </div>
@endsection
