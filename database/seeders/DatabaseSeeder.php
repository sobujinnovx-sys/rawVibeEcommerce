<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with sample admin, customer, categories and products.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@newecom.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'customer@newecom.test'],
            [
                'name' => 'Sample Customer',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        // Demo catalog is seeded only once. This prevents deleted demo products
        // from reappearing when db:seed is executed again.
        if (Product::query()->exists()) {
            return;
        }

        $categoriesData = [
            'Electronics' => 'Gadgets, devices, and accessories for everyday life.',
            'Fashion' => 'Trendy apparel and accessories for every style.',
            'Home & Living' => 'Beautiful items to make your home feel complete.',
            'Books' => 'Bestsellers, classics, and hidden gems.',
        ];

        $productsByCategory = [
            'Electronics' => [
                ['Wireless Headphones', 99.99, 30],
                ['Smart Watch Pro', 149.00, 20],
                ['4K Action Camera', 229.50, 15],
                ['Portable Bluetooth Speaker', 59.00, 40],
            ],
            'Fashion' => [
                ['Classic Denim Jacket', 79.00, 25],
                ['Minimalist Leather Wallet', 29.99, 50],
                ['Running Sneakers', 89.00, 35],
                ['Cotton Crew T-Shirt', 19.99, 100],
            ],
            'Home & Living' => [
                ['Ceramic Dinnerware Set', 69.00, 18],
                ['Scented Soy Candle', 14.50, 60],
                ['Ergonomic Desk Lamp', 49.00, 24],
                ['Plush Throw Blanket', 39.00, 30],
            ],
            'Books' => [
                ['The Modern Developer', 24.99, 40],
                ['Clean Code Principles', 32.00, 25],
                ['Startup Playbook', 18.75, 45],
                ['Design for the Real World', 22.00, 30],
            ],
        ];

        foreach ($categoriesData as $name => $description) {
            $category = Category::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $description,
                    'is_active' => true,
                ]
            );

            $featuredIndex = 0;
            foreach ($productsByCategory[$name] as [$productName, $price, $stock]) {
                Product::query()->updateOrCreate(
                    ['slug' => Str::slug($productName)],
                    [
                        'category_id' => $category->id,
                        'name' => $productName,
                        'price' => $price,
                        'stock' => $stock,
                        'description' => $productName.' — crafted with quality and designed for you. Enjoy premium value without compromise.',
                        'is_featured' => $featuredIndex < 2,
                        'is_active' => true,
                    ]
                );
                $featuredIndex++;
            }
        }
    }
}
