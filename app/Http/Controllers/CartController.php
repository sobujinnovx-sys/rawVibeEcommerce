<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cartItems = $request->user()
            ->carts()
            ->with('product')
            ->latest()
            ->get();

        $subtotal = $this->subtotal($cartItems);

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        if (! $product->is_active || $product->stock < 1) {
            return back()->with('error', 'Product is not available right now.');
        }

        $existing = Cart::query()
            ->where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $newQuantity = min($existing->quantity + 1, $product->stock);
            $existing->update(['quantity' => $newQuantity]);
        } else {
            Cart::query()->create([
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function update(Request $request, Cart $cart): RedirectResponse
    {
        abort_unless($cart->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$cart->product->stock],
        ]);

        $cart->update($validated);

        return back()->with('success', 'Cart updated successfully.');
    }

    public function destroy(Request $request, Cart $cart): RedirectResponse
    {
        abort_unless($cart->user_id === $request->user()->id, 403);

        $cart->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    private function subtotal(Collection $cartItems): float
    {
        return round((float) $cartItems->sum(fn (Cart $item) => $item->quantity * (float) $item->product->effective_price), 2);
    }
}
