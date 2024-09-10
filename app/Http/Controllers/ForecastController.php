<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreForecastRequest;
use App\Http\Requests\UpdateForecastRequest;
use App\Models\Forecast;
use App\Models\Product;
use App\Services\ForecastService;

class ForecastController extends Controller
{
    protected $forecastService;

    public function __construct(ForecastService $forecastService)
    {
        $this->forecastService = $forecastService;
    }

    public function forecast(Product $product)
    {
        // Panggil service untuk melakukan forecast
        $this->forecastService->forecast($product);

        return response()->json([
            'message' => 'Forecasting berhasil dilakukan untuk produk ' . $product->nama_produk
        ]);
    }
}
