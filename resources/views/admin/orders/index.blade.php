@extends('layouts.admin')

@section('title', 'Orders')
@section('page_title', 'Manage Orders')

@section('content')
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Order</th>
                    <th class="text-left px-5 py-3">Customer</th>
                    <th class="text-left px-5 py-3">Total</th>
                    <th class="text-left px-5 py-3">Payment</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($orders as $order)
                    <tr>
                        <td class="px-5 py-3 font-semibold">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-500">#{{ $order->order_number }}</a>
                        </td>
                        <td class="px-5 py-3">{{ $order->user->name ?? $order->shipping_name }}</td>
                        <td class="px-5 py-3">${{ number_format((float) $order->total, 2) }}</td>
                        <td class="px-5 py-3">{{ strtoupper($order->payment_method) }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs bg-slate-100 text-slate-700">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="px-5 py-3 text-slate-500">{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-6 text-center text-slate-500">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
@endsection
