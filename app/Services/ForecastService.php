<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ForecastService
{
  public function calculateForecast(int $productCategoryId): array
  {
    $latestYear = $this->getLatestYear($productCategoryId);

    if (!$latestYear) {
      return [
        'success' => false,
        'message' => "Tidak ada data penjualan untuk kategori ini"
      ];
    }

    $salesData = $this->getSalesData($productCategoryId, $latestYear);

    $forecasts = [];
    foreach ($salesData as $productId => $productSales) {
      $bestAlpha = $this->findBestAlpha($productSales);
      $forecast = $this->calculateSES($productSales, $bestAlpha);
      $errorPercentage = $this->calculateErrorPercentage($productSales, $forecast);

      $forecasts[$productId] = [
        'best_alpha' => $bestAlpha,
        'forecast' => $forecast,
        'error_percentage' => $errorPercentage,
        'sales_data' => $productSales
      ];
    }

    return [
      'success' => true,
      'year' => $latestYear,
      'forecasts' => $forecasts
    ];
  }

  private function getLatestYear(int $productCategoryId): ?int
  {
    return Sale::join('products', 'sales.product_id', '=', 'products.id')
      ->where('products.product_category_id', $productCategoryId)
      ->max(DB::raw('YEAR(periode_penjualan)'));
  }

  private function getSalesData(int $productCategoryId, int $year): array
  {
    $startDate = Carbon::create($year, 1, 1);
    $endDate = Carbon::create($year, 12, 31);

    $sales = Sale::join('products', 'sales.product_id', '=', 'products.id')
      ->where('products.product_category_id', $productCategoryId)
      ->whereBetween('periode_penjualan', [$startDate, $endDate])
      ->groupBy('products.id', 'month')
      ->selectRaw('products.id as product_id, MONTH(periode_penjualan) as month, SUM(jumlah_penjualan) as total_sales')
      ->orderBy('products.id')
      ->orderBy('month')
      ->get();

    $salesData = [];
    foreach ($sales as $sale) {
      $salesData[$sale->product_id][$sale->month] = $sale->total_sales;
    }

    // Fill in missing months with 0 sales
    foreach ($salesData as $productId => $monthlySales) {
      for ($month = 1; $month <= 12; $month++) {
        if (!isset($monthlySales[$month])) {
          $salesData[$productId][$month] = 0;
        }
      }
      ksort($salesData[$productId]);
    }

    return $salesData;
  }

  private function findBestAlpha(array $salesData): float
  {
    $bestAlpha = 0.1;
    $minError = PHP_FLOAT_MAX;

    for ($alpha = 0.1; $alpha <= 0.9; $alpha += 0.1) {
      $forecast = $this->calculateSES($salesData, $alpha);
      $error = $this->calculateErrorPercentage($salesData, $forecast);

      if ($error < $minError) {
        $minError = $error;
        $bestAlpha = $alpha;
      }
    }

    return $bestAlpha;
  }

  private function calculateSES(array $salesData, float $alpha): array
  {
    $forecasts = [];
    $previousForecast = reset($salesData);
    $forecasts[key($salesData)] = $previousForecast;

    foreach ($salesData as $month => $sales) {
      if ($month === key($salesData))
        continue;

      $forecasts[$month] = number_format($previousForecast + (1 - $alpha) * ($sales - $previousForecast), 2);
      $previousForecast = $forecasts[$month];
    }

    return $forecasts;
  }

  private function calculateErrorPercentage(array $actual, array $forecast): float
  {
    $lastActual = end($actual);
    $lastForecast = end($forecast);
    return $lastActual != 0 ? abs(($lastActual - $lastForecast) / $lastActual) * 100 : 0;
  }
}