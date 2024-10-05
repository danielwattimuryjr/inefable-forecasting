<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreForecastRequest;
use App\Http\Requests\UpdateForecastRequest;
use App\Models\Forecast;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\ForecastService;
use App\Traits\SESForecasting;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ForecastController extends Controller
{
    use SESForecasting;

    public function index()
    {
        $productCategories = ProductCategory::orderBy('nama_kategori', 'ASC')->get();
        $forecasts = Forecast::with('product')->orderBy('created_at', 'ASC')->get();

        return view('pages.dashboard.forecasts.index', [
            'productCategories' => $productCategories,
            'forecasts' => $forecasts
        ]);
    }

    public function show(Request $request)
    {
        $validated = $request->validate([
            'product_category_id' => [
                'required',
                Rule::exists('product_categories', 'id')
            ]
        ]);

        $productCategoryId = $validated['product_category_id'];
        $productCount = Product::where('product_category_id', $productCategoryId)->count();

        if ($productCount == 0) {
            return back()->with('response', [
                'success' => false,
                'message' => "Tidak ada produk dalam kategori ini"
            ]);
        }

        $forecast = $this->forecastSales($productCategoryId);

        return view('pages.dashboard.forecasts.show', [
            'productCategoryId' => $validated['product_category_id'],
            'data' => collect($forecast)
        ]);
    }

    public function store($productCategoryId)
    {
        $this->forecastSales($productCategoryId, true);

        return back()->with('response', [
            'success' => true,
            'message' => "Forecast berhasil disimpan",
        ]);
    }

    public function destroy(Forecast $forecast)
    {
        return back()->with('response', [
            'success' => $forecast->delete(),
            'message' => 'Data forecast berhasil dihapus'
        ]);
    }

    public function truncate()
    {
        DB::table('forecasts')->truncate();

        return back()->with('response', [
            'success' => true,
            'message' => 'Seluruh data forecast berhasil dihapus'
        ]);
    }
}
