<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['product_category_id' => 1, 'kode_produk' => 'TS001', 'warna' => 'Blue', 'variasi' => 'Round Neck', 'nama_produk' => 'Classic Blue Tee'],
            ['product_category_id' => 1, 'kode_produk' => 'TS002', 'warna' => 'Red', 'variasi' => 'V-Neck', 'nama_produk' => 'Red V-Neck Tee'],
            ['product_category_id' => 2, 'kode_produk' => 'JN001', 'warna' => 'Blue', 'variasi' => 'Skinny', 'nama_produk' => 'Skinny Blue Jeans'],
            ['product_category_id' => 2, 'kode_produk' => 'JN002', 'warna' => 'Black', 'variasi' => 'Straight', 'nama_produk' => 'Classic Black Jeans'],
            ['product_category_id' => 3, 'kode_produk' => 'DR001', 'warna' => 'Red', 'variasi' => 'Mini', 'nama_produk' => 'Red Mini Dress'],
            ['product_category_id' => 3, 'kode_produk' => 'DR002', 'warna' => 'Black', 'variasi' => 'Maxi', 'nama_produk' => 'Black Maxi Dress'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
