<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
    <input name="name" value="{{ old('name', $category->name ?? '') }}" required
           class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
</div>
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
    <textarea name="description" rows="3"
              class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
</div>
<label class="inline-flex items-center gap-2 text-sm text-slate-700">
    <input type="checkbox" name="is_active" value="1"
           @checked(old('is_active', $category?->is_active ?? true))
           class="rounded text-indigo-600 focus:ring-indigo-500">
    Active
</label>
