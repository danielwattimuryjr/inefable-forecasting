<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition()
    {
        return [
            'product_category_id' => \App\Models\ProductCategory::factory(),
            'kode_produk' => strtoupper($this->faker->unique()->bothify('PROD-####')),
            'warna' => $this->faker->safeColorName(),
            'variasi' => $this->faker->word(),
            'nama_produk' => $this->faker->words(3, true),
        ];
    }
}
