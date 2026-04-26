@extends('layouts.admin')

@section('title', 'Products')
@section('page_title', 'Manage Products')

@section('content')
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-semibold">Products</h2>
        <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-indigo-500">+ New Product</a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Product</th>
                    <th class="text-left px-5 py-3">Category</th>
                    <th class="text-left px-5 py-3">Price</th>
                    <th class="text-left px-5 py-3">Stock</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-5 py-3 flex items-center gap-3">
                            <div class="h-10 w-10 bg-slate-100 rounded-lg overflow-hidden">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" class="h-full w-full object-cover">
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-slate-900">{{ $product->name }}</p>
                                <p class="text-xs text-slate-500">{{ $product->slug }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $product->category->name ?? '—' }}</td>
                        <td class="px-5 py-3">
                            @if ($product->has_discount)
                                <p class="text-xs text-slate-400"><del>৳{{ number_format((float) $product->price, 2) }}</del></p>
                                <p class="font-semibold text-rose-600">৳{{ number_format((float) $product->effective_price, 2) }}</p>
                            @else
                                <p class="font-semibold">৳{{ number_format((float) $product->price, 2) }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3 {{ $product->stock < 5 ? 'text-rose-600 font-semibold' : 'text-slate-600' }}">{{ $product->stock }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if ($product->is_featured)
                                <span class="ml-1 px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-700">Featured</span>
                            @endif
                            @if (!empty($product->promo_label))
                                <span class="ml-1 px-2 py-1 rounded-full text-xs bg-indigo-100 text-indigo-700">{{ $product->promo_label }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-500 text-sm font-semibold">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600 hover:text-rose-500 text-sm font-semibold ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-6 text-center text-slate-500">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
@endsection
