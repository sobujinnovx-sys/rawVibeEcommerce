<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        $wishlistItems = $request->user()
            ->wishlistItems()
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        Wishlist::query()->firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Added to wishlist.');
    }

    public function destroy(Request $request, Wishlist $wishlist): RedirectResponse
    {
        abort_unless($wishlist->user_id === $request->user()->id, 403);

        $wishlist->delete();

        return back()->with('success', 'Removed from wishlist.');
    }
}
