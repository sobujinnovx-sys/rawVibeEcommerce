@extends('layouts.admin')

@section('title', 'Coupons')
@section('page_title', 'Manage Coupons')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold">Coupons</h2>
        <a href="{{ route('admin.coupons.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-indigo-500">+ New Coupon</a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Code</th>
                    <th class="text-left px-5 py-3">Offer</th>
                    <th class="text-left px-5 py-3">Usage</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($coupons as $coupon)
                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $coupon->code }}</td>
                        <td class="px-5 py-3 text-slate-600">
                            @if ($coupon->type === 'percentage')
                                {{ rtrim(rtrim(number_format((float) $coupon->value, 2), '0'), '.') }}% off
                            @else
                                ৳{{ number_format((float) $coupon->value, 2) }} off
                            @endif
                            @if ($coupon->min_order_amount)
                                <div class="text-xs text-slate-400">Min order: ৳{{ number_format((float) $coupon->min_order_amount, 2) }}</div>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-slate-600">
                            {{ $coupon->used_count }}
                            @if ($coupon->usage_limit)
                                / {{ $coupon->usage_limit }}
                            @else
                                / unlimited
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs {{ $coupon->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-indigo-600 hover:text-indigo-500 text-sm font-semibold">Edit</a>
                            <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}" class="inline" onsubmit="return confirm('Delete this coupon?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600 hover:text-rose-500 text-sm font-semibold ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-6 text-center text-slate-500">No coupons yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $coupons->links() }}</div>
@endsection