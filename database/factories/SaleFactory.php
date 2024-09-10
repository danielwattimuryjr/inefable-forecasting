<?php

namespace Database\Factories;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Sale::class;

    public function definition()
    {
        // Ambil waktu sekarang dan buat periode penjualan acak
        $start = Carbon::now()->subMonths(rand(1, 4))->startOfMonth();

        return [
            'product_id' => \App\Models\Product::factory(),
            'periode_penjualan' => $start,
            'jumlah_penjualan' => $this->faker->numberBetween(50, 1000),
        ];
    }
}
