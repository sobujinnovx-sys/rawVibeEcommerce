@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-5 border border-slate-200">
            <p class="text-xs uppercase text-slate-500">Total Sales</p>
            <p class="text-2xl font-bold text-slate-900 mt-2">৳{{ number_format((float) $stats['totalSales'], 2) }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200">
            <p class="text-xs uppercase text-slate-500">Orders</p>
            <p class="text-2xl font-bold text-slate-900 mt-2">{{ $stats['ordersCount'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200">
            <p class="text-xs uppercase text-slate-500">Users</p>
            <p class="text-2xl font-bold text-slate-900 mt-2">{{ $stats['usersCount'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200">
            <p class="text-xs uppercase text-slate-500">Products</p>
            <p class="text-2xl font-bold text-slate-900 mt-2">{{ $stats['productsCount'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-semibold text-slate-900">Latest Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">View all →</a>
        </div>
        @if ($latestOrders->isEmpty())
            <p class="p-6 text-sm text-slate-500">No orders yet.</p>
        @else
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                    <tr><th class="text-left px-5 py-3">Order</th><th class="text-left px-5 py-3">Customer</th><th class="text-left px-5 py-3">Total</th><th class="text-left px-5 py-3">Status</th><th class="text-left px-5 py-3">Date</th></tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($latestOrders as $order)
                        <tr>
                            <td class="px-5 py-3 font-semibold"><a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-500">#{{ $order->order_number }}</a></td>
                            <td class="px-5 py-3">{{ $order->user->name ?? $order->shipping_name }}</td>
                            <td class="px-5 py-3">৳{{ number_format((float) $order->total, 2) }}</td>
                            <td class="px-5 py-3"><span class="px-2 py-1 rounded-full text-xs bg-slate-100 text-slate-700">{{ ucfirst($order->status) }}</span></td>
                            <td class="px-5 py-3 text-slate-500">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
