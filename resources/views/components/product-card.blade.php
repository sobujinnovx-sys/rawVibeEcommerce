@props(['product'])

<div class="group bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-xl transition-shadow flex flex-col">
    <a href="{{ route('shop.show', $product) }}" class="block aspect-square overflow-hidden bg-slate-100">
        @if ($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
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
        <div class="mt-auto flex items-center justify-between pt-3">
            <span class="text-base font-semibold text-slate-900"><span class="font-bold">৳</span>{{ number_format((float) $product->price, 2) }}</span>
            @auth
                <form method="POST" action="{{ route('cart.store', $product) }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1 text-xs font-semibold bg-indigo-600 text-white rounded-full px-3 py-1.5 hover:bg-indigo-500 disabled:opacity-60"
                        @disabled($product->stock < 1)>
                        {{ $product->stock > 0 ? __('Add to Cart') : __('Out of Stock') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-xs font-semibold bg-indigo-600 text-white rounded-full px-3 py-1.5 hover:bg-indigo-500">{{ __('Buy') }}</a>
            @endauth
        </div>
    </div>
</div>
