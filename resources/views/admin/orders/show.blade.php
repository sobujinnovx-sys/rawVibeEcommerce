@extends('layouts.admin')

@section('title', 'Order #'.$order->order_number)
@section('page_title', 'Order Details')

@section('content')
    <div class="grid lg:grid-cols-[1fr_340px] gap-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Order #{{ $order->order_number }}</h2>
                    <p class="text-sm text-slate-500">Placed on {{ $order->created_at->format('M d, Y · h:i A') }}</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-sm">{{ ucfirst($order->status) }}</span>
            </div>

            <table class="w-full text-sm">
                <thead class="text-slate-500 text-left">
                    <tr><th class="py-2">Product</th><th class="py-2 text-right">Qty</th><th class="py-2 text-right">Price</th><th class="py-2 text-right">Total</th></tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="py-2">{{ $item->product_name }}</td>
                            <td class="py-2 text-right">{{ $item->quantity }}</td>
                            <td class="py-2 text-right">
                                @if ($item->original_price && (float) $item->original_price > (float) $item->price)
                                    <span class="mr-2 text-xs text-slate-400 line-through">৳{{ number_format((float) $item->original_price, 2) }}</span>
                                @endif
                                ৳{{ number_format((float) $item->price, 2) }}
                            </td>
                            <td class="py-2 text-right">৳{{ number_format((float) $item->line_total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <dl class="mt-4 space-y-1 text-sm text-right">
                <div class="flex justify-end gap-6"><dt>Subtotal</dt><dd>৳{{ number_format((float) $order->subtotal, 2) }}</dd></div>
                @if ((float) $order->coupon_discount > 0)
                    <div class="flex justify-end gap-6 text-emerald-600"><dt>Coupon Discount</dt><dd>-৳{{ number_format((float) $order->coupon_discount, 2) }} @if($order->coupon_code)({{ $order->coupon_code }})@endif</dd></div>
                @endif
                <div class="flex justify-end gap-6"><dt>Shipping</dt><dd>৳{{ number_format((float) $order->shipping_cost, 2) }}</dd></div>
                <div class="flex justify-end gap-6 text-base font-semibold text-slate-900"><dt>Total</dt><dd>৳{{ number_format((float) $order->total, 2) }}</dd></div>
            </dl>
        </div>

        <aside class="space-y-4">
            <div class="bg-white border border-slate-200 rounded-2xl p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Customer</h3>
                <p class="text-sm text-slate-600">{{ $order->user->name ?? $order->shipping_name }}</p>
                <p class="text-sm text-slate-600">{{ $order->shipping_email }}</p>
                <p class="text-sm text-slate-600">{{ $order->shipping_phone }}</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Shipping Address</h3>
                <p class="text-sm text-slate-600">{{ $order->shipping_address }}</p>
                <p class="text-sm text-slate-600">{{ $order->shipping_city }} {{ $order->shipping_postal_code }}</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-6">
                <h3 class="font-semibold text-slate-900 mb-3">Update Status</h3>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @foreach (['pending','processing','shipped','delivered','cancelled'] as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button class="w-full bg-indigo-600 text-white py-2 rounded-full font-semibold text-sm hover:bg-indigo-500">Update Status</button>
                </form>
            </div>
            <div class="bg-white border border-rose-200 rounded-2xl p-6">
                <h3 class="font-semibold text-rose-700 mb-2">Danger Zone</h3>
                <p class="text-xs text-slate-500 mb-3">Deleting this order will permanently remove it and all its items.</p>
                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Delete this order? This cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-rose-600 text-white py-2 rounded-full font-semibold text-sm hover:bg-rose-500">Delete Order</button>
                </form>
            </div>
        </aside>
    </div>
@endsection
