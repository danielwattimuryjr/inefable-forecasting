<?php

namespace App\Traits;

use App\Models\Forecast;
use App\Models\Sale;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait SESForecasting
{
    public function forecastSales($productCategoryId, $saveResult = false)
    {
        $products = Product::where('product_category_id', $productCategoryId)->get();
        $results = [];

        foreach ($products as $product) {
            $salesData = $this->getMonthlySalesData($product->id);
            if (count($salesData) > 0) {
                [$bestAlpha, $minMAPE] = $this->findBestAlpha($salesData);
                $forecast = $this->calculateMonthlyForecast($salesData, $bestAlpha);

                $results[] = [
                    'id' => $product->id,
                    'nama_produk' => $product->nama_produk,
                    'forecast' => [
                        'month' => $forecast['month'],
                        'result' => round($forecast['forecast']),
                        'alpha' => $bestAlpha,
                        'mape' => round($minMAPE, 3)
                    ]
                ];

                if ($saveResult) {
                    $this->saveOrUpdateForecast($product->id, $forecast, $bestAlpha, $minMAPE);
                }
            }
        }

        return ["result" => $results];
    }

    private function getMonthlySalesData($productId)
    {
        $salesData = Sale::where('product_id', $productId)
            ->select(DB::raw('DATE_FORMAT(periode_penjualan, "%Y-%m-01") as month'), DB::raw('SUM(jumlah_penjualan) as total_sales'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->month,
                    'sales' => (float) $item->total_sales
                ];
            })
            ->toArray();

        return $salesData;
    }

    private function findBestAlpha($salesData)
    {
        $bestAlpha = 0;
        $minMAPE = PHP_FLOAT_MAX;
        $allErrors = [];

        for ($alpha = 0.1; $alpha <= 0.9; $alpha += 0.1) {
            $mape = $this->calculateMAPE($salesData, $alpha);
            $allErrors[number_format($alpha, 1)] = $mape;

            if ($mape < $minMAPE) {
                $minMAPE = $mape;
                $bestAlpha = $alpha;
            }
        }

        return [$bestAlpha, $minMAPE];
    }

    private function calculateMAPE($salesData, $alpha)
    {
        $forecast = $salesData[0]['sales'];
        $totalError = 0;
        $n = count($salesData);

        for ($i = 1; $i < $n; $i++) {
            $actual = $salesData[$i]['sales'];
            if ($actual != 0) {
                $error = abs(($actual - $forecast) / $actual);
                $totalError += $error;
            }
            $forecast = $alpha * $actual + (1 - $alpha) * $forecast;
        }

        return $totalError / ($n - 1);
    }

    private function calculateMSE($salesData, $alpha)
    {
        $forecast = $salesData[0]['sales'];
        $mse = 0;
        $n = count($salesData);

        for ($i = 1; $i < $n; $i++) {
            $actual = $salesData[$i]['sales'];
            $error = $actual - $forecast;
            $mse += $error * $error;
            $forecast = $alpha * $actual + (1 - $alpha) * $forecast;
        }

        return $mse / ($n - 1);
    }

    private function calculateMonthlyForecast($salesData, $alpha)
    {
        if (empty($salesData)) {
            return ['month' => Carbon::now()->addMonth()->format('Y-m'), 'forecast' => 0];
        }

        $lastMonth = end($salesData);
        $forecast = $lastMonth['sales'];

        if (count($salesData) > 1) {
            $previousMonth = $salesData[count($salesData) - 2];
            $forecast = $alpha * $lastMonth['sales'] + (1 - $alpha) * $previousMonth['sales'];
        }

        $nextMonth = Carbon::parse($lastMonth['date'])->addMonth();

        return [
            'month' => $nextMonth->format('Y-m'),
            'forecast' => $forecast
        ];
    }

    private function saveOrUpdateForecast($productId, $forecast, $alpha, $mape)
    {
        Forecast::updateOrCreate(
            [
                'product_id' => $productId,
                'periode' => $forecast['month'] . '-01',
            ],
            [
                'value' => round($forecast['forecast']),
                'alpha' => $alpha,
                'mape' => $mape,
            ]
        );
    }
}
