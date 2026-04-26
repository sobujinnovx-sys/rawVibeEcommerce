<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCheckoutRequest;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use App\Services\Payments\PaymentManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $cartItems = $user
            ->carts()
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->cartSubtotal($cartItems);
        $shippingCost = 0;
        $coupon = $this->couponFromSession($request, $subtotal);
        $couponDiscount = $coupon?->discountAmount($subtotal) ?? 0.0;
        $total = max(0, $subtotal - $couponDiscount + $shippingCost);

        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingCost', 'coupon', 'couponDiscount', 'total'));
    }

    public function applyCoupon(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'coupon_code' => ['required', 'string', 'max:50'],
        ]);

        $cartItems = $request->user()
            ->carts()
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->cartSubtotal($cartItems);
        $coupon = $this->resolveCouponOrFail($validated['coupon_code'], $subtotal);

        $request->session()->put('checkout.coupon_code', $coupon->code);

        return back()->with('success', 'Coupon applied successfully.');
    }

    public function removeCoupon(Request $request): RedirectResponse
    {
        $request->session()->forget('checkout.coupon_code');

        return back()->with('success', 'Coupon removed successfully.');
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

        $subtotal = $this->cartSubtotal($cartItems);
        $shippingCost = 0;
        $couponCode = trim((string) ($request->input('coupon_code') ?: $request->session()->get('checkout.coupon_code', '')));

        $order = DB::transaction(function () use ($request, $paymentManager, $user, $cartItems, $subtotal, $shippingCost, $couponCode) {
            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    abort(422, "Insufficient stock for {$item->product->name}.");
                }
            }

            $coupon = $this->resolveCouponOrFail($couponCode, $subtotal, true);
            $couponDiscount = $coupon?->discountAmount($subtotal) ?? 0.0;
            $total = max(0, $subtotal - $couponDiscount + $shippingCost);

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
                'coupon_code' => $coupon?->code,
                'coupon_discount' => $couponDiscount,
                'shipping_cost' => $shippingCost,
                'total' => $total,
            ]);

            foreach ($cartItems as $item) {
                $unitPrice = (float) $item->product->effective_price;

                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'original_price' => $item->product->price,
                    'price' => $unitPrice,
                    'quantity' => $item->quantity,
                    'line_total' => $item->quantity * $unitPrice,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            if ($coupon) {
                $coupon->increment('used_count');
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

        $request->session()->forget('checkout.coupon_code');

        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully.');
    }

    public function success(Order $order): View
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items');

        return view('checkout.success', compact('order'));
    }

    private function cartSubtotal(Collection $cartItems): float
    {
        return round((float) $cartItems->sum(fn (Cart $item) => $item->quantity * (float) $item->product->effective_price), 2);
    }

    private function couponFromSession(Request $request, float $subtotal): ?Coupon
    {
        $couponCode = $request->session()->get('checkout.coupon_code');

        if (!filled($couponCode)) {
            return null;
        }

        try {
            return $this->resolveCouponOrFail((string) $couponCode, $subtotal);
        } catch (ValidationException) {
            $request->session()->forget('checkout.coupon_code');

            return null;
        }
    }

    private function resolveCouponOrFail(?string $couponCode, float $subtotal, bool $lockForUpdate = false): ?Coupon
    {
        if (!filled($couponCode)) {
            return null;
        }

        $normalizedCode = Str::upper(trim((string) $couponCode));
        $query = Coupon::query()->where('code', $normalizedCode);

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        $coupon = $query->first();

        if (!$coupon) {
            throw ValidationException::withMessages([
                'coupon_code' => 'The coupon code is invalid.',
            ]);
        }

        if (!$coupon->canBeAppliedTo($subtotal)) {
            throw ValidationException::withMessages([
                'coupon_code' => 'This coupon cannot be applied to the current order.',
            ]);
        }

        return $coupon;
    }
}
