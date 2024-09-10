<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Forecast;
use App\Models\Product;
use Carbon\Carbon;

class ForecastService
{
  public function forecast(Product $product)
  {
    $sales = Sale::where('product_id', $product->id)
      ->orderBy('periode_penjualan', 'asc')
      ->get();

    $monthlySales = $sales->groupBy(function ($sale) {
      return Carbon::parse($sale->periode_penjualan)->format('Y-m');
    })->map(function ($sales) {
      return $sales->sum('jumlah_penjualan');
    });

    $bestAlpha = 0.1;
    $minMape = INF;
    $forecastedValue = null;

    for ($alpha = 0.1; $alpha <= 0.9; $alpha += 0.1) {
      $previousForecast = $monthlySales->first();
      $totalMape = 0;
      $count = 0;

      foreach ($monthlySales as $month => $sales) {
        $forecast = ($alpha * $sales) + ((1 - $alpha) * $previousForecast);
        $previousForecast = $forecast;

        $mape = $sales ? abs(($sales - $forecast) / $sales) * 100 : 0;
        $totalMape += $mape;
        $count++;
      }

      $averageMape = $count > 0 ? $totalMape / $count : INF;

      if ($averageMape < $minMape) {
        $minMape = $averageMape;
        $bestAlpha = $alpha;
        $forecastedValue = $previousForecast;
      }
    }

    $nextMonth = Carbon::now()->addMonth()->startOfMonth();

    Forecast::updateOrCreate(
      [
        'product_id' => $product->id,
        'periode' => $nextMonth,
      ],
      [
        'value' => round($forecastedValue),
        'alpha' => $bestAlpha,
        'mape' => $minMape,
      ]
    );
  }
}
