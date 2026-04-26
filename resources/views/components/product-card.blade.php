@props(['product'])

<div class="group bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-xl transition-shadow flex flex-col">
    <a href="{{ route('shop.show', $product) }}" class="relative block aspect-square overflow-hidden bg-slate-100">
        @if ($product->has_discount)
            <div class="absolute z-10 m-2 inline-flex items-center rounded-full bg-rose-600 px-2 py-1 text-[11px] font-bold text-white">
                -{{ $product->discount_percentage }}%
            </div>
        @elseif (!empty($product->promo_label))
            <div class="absolute z-10 m-2 inline-flex items-center rounded-full bg-amber-500 px-2 py-1 text-[11px] font-bold text-white">
                {{ $product->promo_label }}
            </div>
        @endif
        @if ($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center text-slate-300">
                <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z M4 16l4.5-4.5 3 3L15 11l5 5 M9 9a1 1 0 100 2 1 1 0 000-2z"/>
                </svg>
            </div>
        @endif
    </a>
    <div class="p-4 flex flex-col gap-2 flex-1">
        <span class="text-xs uppercase tracking-wide text-indigo-600">{{ $product->category?->name ?? __('Product') }}</span>
        <a href="{{ route('shop.show', $product) }}" class="font-semibold text-slate-900 line-clamp-1 hover:text-indigo-600">
            {{ $product->name }}
        </a>
        <div class="mt-auto flex items-center justify-between gap-2 pt-3">
            <div class="shrink-0">
                @if ($product->has_discount)
                    <p class="text-[11px] text-slate-400 line-through"><span class="font-bold">৳</span>{{ number_format((float) $product->price, 2) }}</p>
                    <p class="text-base font-semibold text-rose-600"><span class="font-bold">৳</span>{{ number_format((float) $product->effective_price, 2) }}</p>
                @else
                    <p class="text-base font-semibold text-slate-900"><span class="font-bold">৳</span>{{ number_format((float) $product->price, 2) }}</p>
                @endif
            </div>
            @auth
                @if (!auth()->user()->isAdmin())
                <form method="POST" action="{{ route('cart.store', $product) }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap text-xs font-semibold bg-indigo-600 text-white rounded-full px-4 py-2 hover:bg-indigo-500 disabled:opacity-60"
                        @disabled($product->stock < 1)>
                        {{ $product->stock > 0 ? __('Add to Cart') : __('Out of Stock') }}
                    </button>
                </form>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center whitespace-nowrap text-xs font-semibold rounded-full border border-slate-200 px-4 py-2 text-slate-600 hover:border-indigo-200 hover:text-indigo-600">{{ __('Admin View') }}</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center whitespace-nowrap text-xs font-semibold bg-indigo-600 text-white rounded-full px-4 py-2 hover:bg-indigo-500">{{ __('Buy') }}</a>
            @endauth
        </div>
    </div>
</div>
