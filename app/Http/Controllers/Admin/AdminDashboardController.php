<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalSales = Order::query()
            ->where('status', Order::STATUS_DELIVERED)
            ->sum('total');

        $stats = [
            'totalSales' => $totalSales,
            'ordersCount' => Order::query()->count(),
            'usersCount' => User::query()->count(),
            'productsCount' => Product::query()->count(),
        ];

        $latestOrders = Order::query()
            ->with('user')
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestOrders'));
    }
}
