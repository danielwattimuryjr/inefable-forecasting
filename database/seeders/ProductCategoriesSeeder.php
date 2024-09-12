<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'T-Shirts'],
            ['nama_kategori' => 'Jeans'],
            ['nama_kategori' => 'Dresses'],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
