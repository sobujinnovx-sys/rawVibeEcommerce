<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Services\Payments\PaymentManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cartItems = auth()->user()
            ->carts()
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn (Cart $item) => $item->quantity * (float) $item->product->price);
        $shippingCost = 0;
        $total = $subtotal + $shippingCost;

        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    public function store(StoreCheckoutRequest $request, PaymentManager $paymentManager): RedirectResponse
    {
        $user = $request->user();

        $cartItems = $user->carts()
            ->with('product')
            ->lockForUpdate()
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn (Cart $item) => $item->quantity * (float) $item->product->price);
        $shippingCost = 0;
        $total = $subtotal + $shippingCost;

        $order = DB::transaction(function () use ($request, $paymentManager, $user, $cartItems, $subtotal, $shippingCost, $total) {
            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    abort(422, "Insufficient stock for {$item->product->name}.");
                }
            }

            $order = Order::query()->create([
                'user_id' => $user->id,
                'order_number' => 'ORD-'.now()->format('YmdHis').'-'.$user->id,
                'status' => Order::STATUS_PENDING,
                'payment_method' => $request->string('payment_method')->toString(),
                'payment_status' => 'unpaid',
                'shipping_name' => $request->string('shipping_name')->toString(),
                'shipping_email' => $request->string('shipping_email')->toString(),
                'shipping_phone' => $request->string('shipping_phone')->toString(),
                'shipping_address' => $request->string('shipping_address')->toString(),
                'shipping_city' => $request->string('shipping_city')->toString(),
                'shipping_postal_code' => $request->string('shipping_postal_code')->toString() ?: null,
                'notes' => $request->string('notes')->toString() ?: null,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'line_total' => $item->quantity * $item->product->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            $paymentResult = $paymentManager
                ->driver($request->string('payment_method')->toString())
                ->charge($order, []);

            $order->update([
                'payment_status' => $paymentResult['payment_status'] ?? 'unpaid',
            ]);

            $user->carts()->delete();

            return $order;
        });

        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully.');
    }

    public function success(Order $order): View
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items');

        return view('checkout.success', compact('order'));
    }
}
