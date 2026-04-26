<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Coupon Code</label>
        <input name="code" value="{{ old('code', $coupon->code ?? '') }}" required
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm uppercase">
        @error('code') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Type</label>
        <select name="type" required class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            <option value="fixed" @selected(old('type', $coupon->type ?? 'fixed') === 'fixed')>Fixed amount</option>
            <option value="percentage" @selected(old('type', $coupon->type ?? '') === 'percentage')>Percentage</option>
        </select>
        @error('type') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Value</label>
        <input name="value" type="number" step="0.01" min="0.01" value="{{ old('value', $coupon->value ?? '') }}" required
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('value') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Minimum Order Amount</label>
        <input name="min_order_amount" type="number" step="0.01" min="0" value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}"
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('min_order_amount') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Usage Limit</label>
        <input name="usage_limit" type="number" min="1" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}"
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('usage_limit') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Used Count</label>
        <input value="{{ $coupon->used_count ?? 0 }}" disabled
               class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm text-slate-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Starts At</label>
        <input name="starts_at" type="datetime-local"
               value="{{ old('starts_at', isset($coupon?->starts_at) ? $coupon->starts_at->format('Y-m-d\TH:i') : '') }}"
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('starts_at') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Ends At</label>
        <input name="ends_at" type="datetime-local"
               value="{{ old('ends_at', isset($coupon?->ends_at) ? $coupon->ends_at->format('Y-m-d\TH:i') : '') }}"
               class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('ends_at') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<label class="inline-flex items-center gap-2 text-sm text-slate-700">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $coupon?->is_active ?? true))
           class="rounded text-indigo-600 focus:ring-indigo-500">
    Active
</label>