<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CarouselBanner;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $carouselBanners = collect();

        if (Schema::hasTable('carousel_banners')) {
            try {
                $carouselBanners = CarouselBanner::query()
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->latest('id')
                    ->get();
            } catch (\Throwable $exception) {
                $carouselBanners = collect();
            }
        }

        $featuredProducts = Product::query()
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $latestProducts = Product::query()
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->take(8)
            ->get();

        return view('home', compact('carouselBanners', 'featuredProducts', 'latestProducts', 'categories'));
    }
}
