<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreForecastRequest;
use App\Http\Requests\UpdateForecastRequest;
use App\Models\Forecast;
use App\Models\Product;
use App\Models\ProductCategory;
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

    public function index() {
        $productCategories = ProductCategory::orderBy('nama_kategori', 'ASC')
            ->get();

        return view('pages.dashboard.forecasts.index', [
            'productCategories' => $productCategories
        ]);
    }

    public function store(StoreForecastRequest $request) {
        $validated = $request->validated();

        $productCount = Product::where('product_category_id', $validated['product_category_id'])
            ->count();

        if ($productCount == 0) {
            return back()->with('response', [
                'success' => false,
                'message' => "Produk masih 0"
            ]);
        }

        return back()->with('response', [
            'success' => true,
            'message' => "Nice"
        ]);
    }
}
