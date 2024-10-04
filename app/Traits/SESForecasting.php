<?php

namespace App\Traits;

use App\Models\Forecast;
use App\Models\Sale;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait SESForecasting
{
    public function forecastSales($productCategoryId)
    {
        $products = Product::where('product_category_id', $productCategoryId)
            ->get();
        $results = [];

        foreach ($products as $product) {
            $salesData = $this->getMonthlySalesData($product->id);
            if (count($salesData) > 0) {
                [$bestAlpha, $minMAPE] = $this->findBestAlpha($salesData);
                $forecast = $this->calculateMonthlyForecast($salesData, $bestAlpha);
                $results[$product->id] = [
                    'product_name' => $product->nama_produk,
                    'forecast' => [
                        'month' => $forecast['month'],
                        'result' => $forecast['forecast'],
                        'best_alpha' => $bestAlpha,
                        'mape' => number_format($minMAPE, 3),
                    ]
                ];

                $this->saveOrUpdateForecast($product->id, $forecast, $bestAlpha, $minMAPE);
            }
        }

        return [
            "result" => $results,
        ]; 
    }

    private function getMonthlySalesData($productId)
    {
        $firstSale = Sale::where('product_id', $productId)
            ->orderBy('periode_penjualan', 'asc')
            ->first();
        $lastSale = Sale::where('product_id', $productId)
            ->orderBy('periode_penjualan', 'desc')
            ->first();

        if (!($firstSale || $lastSale)) {
            return [];
        }

        $startDate = Carbon::parse($firstSale->periode_penjualan)->startOfMonth();
        $endDate = Carbon::parse($lastSale->periode_penjualan)->endOfMonth();

        $salesData = Sale::where('product_id', $productId)
            ->whereBetween('periode_penjualan', [$startDate, $endDate])
            ->select(DB::raw('DATE_FORMAT(periode_penjualan, "%Y-%m-01") as month'), DB::raw('SUM(jumlah_penjualan) as total_sales'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $allMonths = new \DatePeriod($startDate, new \DateInterval('P1M'), $endDate);
        $salesByMonth = $salesData->keyBy('month');
        $filledSalesData = [];

        foreach ($allMonths as $date) {
            $monthString = $date->format('Y-m-01');
            $filledSalesData[] = [
                'date' => $monthString,
                'sales' => $salesByMonth->get($monthString, ['total_sales' => 0])['total_sales']
            ];
        }

        return $filledSalesData;
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
        $lastDate = Carbon::parse(end($salesData)['date']);
        $nextMonth = $lastDate->copy()->addMonth()->startOfMonth();
        $daysInMonth = $nextMonth->daysInMonth;

        $lastSales = end($salesData)['sales'];
        $forecast = $lastSales;

        $dailyForecasts = [];
        for ($i = 0; $i < $daysInMonth; $i++) {
            $forecast = $alpha * $lastSales + (1 - $alpha) * $forecast;
            $dailyForecasts[] = $forecast;
            $lastSales = $forecast;
        }

        $monthlyForecast = array_sum($dailyForecasts);

        return [
            'month' => $nextMonth->format('Y-m'),
            'forecast' => round($monthlyForecast, 2)
        ];
    }

    private function saveOrUpdateForecast($productId, $forecast, $alpha, $mape)
    {
        Forecast::updateOrCreate(
            [
                'product_id' => $productId,
                'periode' => $forecast['month'] . '-01', // Menggunakan hari pertama bulan
            ],
            [
                'value' => round($forecast['forecast']),
                'alpha' => $alpha,
                'mape' => $mape,
            ]
        );
    }
}
