<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->with('user')
            ->latest()
            ->paginate(12);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $order->update([
            'status' => $request->string('status')->toString(),
        ]);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        try {
            $order->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Cannot delete this order because it is referenced by other records.');
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
