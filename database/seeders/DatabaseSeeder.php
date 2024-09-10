<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Sale;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'nama' => 'Test User',
            'username' => 'test.user',
            'email' => 'test@example.com',
            'role' => 'direktur_operasional'
        ]);

        // Membuat 3 kategori produk
        $categories = ProductCategory::factory(3)->create();

        // Untuk setiap kategori, buat 5 produk
        $categories->each(function ($category) {
            $products = Product::factory(5)->create([
                'product_category_id' => $category->id
            ]);

            // Untuk setiap produk, buat sales dari 1 sampai 4 bulan terakhir
            $products->each(function ($product) {
                Sale::factory(rand(1, 4))->create([
                    'product_id' => $product->id
                ]);
            });
        });
    }
}
