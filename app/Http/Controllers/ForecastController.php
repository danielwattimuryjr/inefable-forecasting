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


    public function getAvailableYears(int $productCategoryId): JsonResponse
    {
        $years = $this->forecastService->getAvailableYears($productCategoryId);
        return response()->json($years);
    }

    public function index()
    {
        $productCategories = ProductCategory::orderBy('nama_kategori', 'ASC')
            ->get();

        return view('pages.dashboard.forecasts.index', [
            'productCategories' => $productCategories
        ]);
    }

    public function store(StoreForecastRequest $request)
    {
        // $validated = $request->validated();
        // $productCount = Product::where('product_category_id', $validated['product_category_id'])->count();

        // if ($productCount == 0) {
        //     return back()->with('response', [
        //         'success' => false,
        //         'message' => "Produk masih 0"
        //     ]);
        // }

        // return back()->with('response', [
        //     'success' => true,
        //     'message' => "Forecast berhasil untuk kategori {$validated['product_category_id']}",
        // ]);

        $validated = $request->validated();
        $productCategoryId = $validated['product_category_id'];

        $productCount = Product::where('product_category_id', $productCategoryId)->count();

        if ($productCount == 0) {
            return response()->json([
                'success' => false,
                'message' => "Tidak ada produk dalam kategori ini"
            ], 400);
        }

        $forecastResult = $this->forecastService->calculateForecast($productCategoryId);

        return response()->json([
            'success' => true,
            'message' => "Forecast berhasil untuk kategori {$productCategoryId}",
            'data' => $forecastResult
        ]);
    }
}
