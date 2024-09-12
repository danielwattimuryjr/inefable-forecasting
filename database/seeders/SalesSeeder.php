<?php

namespace Database\Seeders;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $productSales = [
            1 => [283, 300, 330, 374, 343, 332, 383, 312, 329, 309, 335, 349],
            2 => [171, 197, 218, 242, 261, 328, 297, 268, 287, 290, 286, 291],
            3 => [188, 182, 232, 229, 268, 311, 308, 281, 302, 287, 291, 297]
        ];

        foreach ($productSales as $productId => $monthlySales) {
            $startDate = Carbon::create(2022, 1, 1);

            foreach ($monthlySales as $month => $totalSales) {
                $daysInMonth = $startDate->daysInMonth;
                $dailySales = $this->distributeSales($totalSales, $daysInMonth);

                foreach ($dailySales as $day => $sales) {
                    Sale::create([
                        'product_id' => $productId,
                        'periode_penjualan' => $startDate->copy()->addDays($day - 1),
                        'jumlah_penjualan' => $sales,
                    ]);
                }

                $startDate->addMonth();
            }
        }
    }

    private function distributeSales($totalSales, $days)
    {
        $dailySales = array_fill(1, $days, 0);
        $remainingSales = $totalSales;

        while ($remainingSales > 0) {
            for ($i = 1; $i <= $days && $remainingSales > 0; $i++) {
                $sale = mt_rand(0, min(10, $remainingSales));
                $dailySales[$i] += $sale;
                $remainingSales -= $sale;
            }
        }

        return $dailySales;
    }
}
