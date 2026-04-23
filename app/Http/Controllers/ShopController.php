<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', function ($categoryQuery) use ($request) {
                    $categoryQuery->where('slug', $request->string('category'));
                });
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = $request->string('search');
                $query->where(function ($innerQuery) use ($term) {
                    $innerQuery->where('name', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('shop.index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $request->string('category')->toString(),
            'search' => $request->string('search')->toString(),
        ]);
    }

    public function show(Product $product): View
    {
        abort_if(! $product->is_active, 404);

        $product->load([
            'reviews' => function ($query) {
                $query->with('user')->latest();
            },
        ]);

        $relatedProducts = Product::query()
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->latest()
            ->take(4)
            ->get();

        $canReview = false;

        if (auth()->check()) {
            /** @var User $user */
            $user = auth()->user();

            $canReview = $user->orders()
                ->whereHas('items', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })
                ->exists();
        }

        return view('shop.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'canReview' => $canReview,
        ]);
    }
}
