<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductReviewRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class ProductReviewController extends Controller
{
    public function store(StoreProductReviewRequest $request, Product $product): RedirectResponse
    {
        $user = $request->user();

        abort_if(! $product->is_active, 404);

        $hasPurchasedProduct = $user->orders()
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists();

        abort_unless($hasPurchasedProduct, 403);

        $product->reviews()->updateOrCreate(
            ['user_id' => $user->id],
            $request->validated(),
        );

        return back()->with('success', __('Your review has been saved.'));
    }
}