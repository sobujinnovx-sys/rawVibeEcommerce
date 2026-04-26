<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
        <input name="title" value="{{ old('title', $banner->title ?? '') }}" required
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Subtitle</label>
        <input name="subtitle" value="{{ old('subtitle', $banner->subtitle ?? '') }}"
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('subtitle') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Button Text</label>
        <input name="button_text" value="{{ old('button_text', $banner->button_text ?? '') }}"
               placeholder="Example: Shop Now"
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('button_text') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Button Link</label>
        <input name="button_link" type="url" value="{{ old('button_link', $banner->button_link ?? '') }}"
               placeholder="https://example.com/shop"
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('button_link') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Sort Order</label>
        <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $banner->sort_order ?? 0) }}"
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('sort_order') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Banner Image</label>
    @if (!empty($banner?->image_url))
        <img src="{{ $banner->image_url }}" class="h-24 w-40 rounded-lg mb-2 object-cover">
    @endif
    <input type="file" name="image" class="text-sm">
    @error('image') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
</div>
<div class="flex flex-wrap gap-6 pt-2">
    <label class="inline-flex items-center gap-2 text-sm text-slate-700">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $banner?->is_active ?? true)) class="rounded text-indigo-600 focus:ring-indigo-500">
        Active
    </label>
</div>
