<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::query()
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::query()->where('is_active', true)->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['discount_price'] = $validated['discount_price'] ?? null;
        $validated['promo_label'] = filled($validated['promo_label'] ?? null) ? trim((string) $validated['promo_label']) : null;
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = ImageUploadService::upload($request->file('image'), 'products');
        }

        Product::query()->create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();
        $validated['discount_price'] = $validated['discount_price'] ?? null;
        $validated['promo_label'] = filled($validated['promo_label'] ?? null) ? trim((string) $validated['promo_label']) : null;
        if ($product->name !== $validated['name']) {
            $validated['slug'] = $this->uniqueSlug($validated['name'], $product->id);
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            ImageUploadService::delete($product->image);
            $validated['image'] = ImageUploadService::upload($request->file('image'), 'products');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->orderItems()->exists()) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Cannot delete this product because it is referenced by existing orders.');
        }

        try {
            ImageUploadService::delete($product->image);
            $product->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Cannot delete this product because it is referenced by other records.');
        }

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 1;

        while (Product::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
