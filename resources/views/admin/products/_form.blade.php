<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
        <input name="name" value="{{ old('name', $product->name ?? '') }}" required
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
        <select name="category_id" required
                class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            <option value="">Select a category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Price</label>
        <input name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price ?? '') }}" required
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('price') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Discounted Price</label>
        <input name="discount_price" type="number" step="0.01" min="0" value="{{ old('discount_price', $product->discount_price ?? '') }}"
               placeholder="Leave empty for no discount"
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('discount_price') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Promo Label</label>
        <input name="promo_label" value="{{ old('promo_label', $product->promo_label ?? '') }}"
               placeholder="Example: EID DEAL, FLASH SALE"
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('promo_label') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Stock</label>
        <input name="stock" type="number" min="0" value="{{ old('stock', $product->stock ?? 0) }}" required
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('stock') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
    <textarea name="description" rows="5"
              class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('description', $product->description ?? '') }}</textarea>
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Image</label>
    @if (!empty($product?->image))
        <img src="{{ $product->image_url }}" class="h-24 rounded-lg mb-2">
    @endif
    <input type="file" name="image" class="text-sm">
    @error('image') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
</div>
<div class="flex flex-wrap gap-6 pt-2">
    <label class="inline-flex items-center gap-2 text-sm text-slate-700">
        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product?->is_featured ?? false)) class="rounded text-indigo-600 focus:ring-indigo-500">
        Featured
    </label>
    <label class="inline-flex items-center gap-2 text-sm text-slate-700">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product?->is_active ?? true)) class="rounded text-indigo-600 focus:ring-indigo-500">
        Active
    </label>
</div>
