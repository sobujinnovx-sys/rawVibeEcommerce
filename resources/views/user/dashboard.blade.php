@extends('layouts.storefront')

@section('title', 'My Orders — RAW VIBE ツ')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Welcome, {{ auth()->user()->name }}</h1>
                <p class="text-slate-500">Track your orders and account activity.</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Edit Profile →</a>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-semibold text-slate-900">Order History</h2>
            </div>
            @if ($orders->isEmpty())
                <div class="p-10 text-center text-slate-500">You haven't placed any orders yet.</div>
            @else
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                        <tr>
                            <th class="text-left px-5 py-3">Order #</th>
                            <th class="text-left px-5 py-3">Date</th>
                            <th class="text-left px-5 py-3">Items</th>
                            <th class="text-left px-5 py-3">Total</th>
                            <th class="text-left px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="px-5 py-3 font-semibold text-slate-900">#{{ $order->order_number }}</td>
                                <td class="px-5 py-3 text-slate-600">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-5 py-3 text-slate-600">{{ $order->items->sum('quantity') }}</td>
                                <td class="px-5 py-3 font-semibold">${{ number_format((float) $order->total, 2) }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                                        @switch($order->status)
                                            @case('delivered') bg-emerald-100 text-emerald-700 @break
                                            @case('shipped') bg-sky-100 text-sky-700 @break
                                            @case('processing') bg-amber-100 text-amber-700 @break
                                            @case('cancelled') bg-rose-100 text-rose-700 @break
                                            @default bg-slate-100 text-slate-700
                                        @endswitch
                                    ">{{ ucfirst($order->status) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">{{ $orders->links() }}</div>
            @endif
        </div>
    </div>
@endsection
