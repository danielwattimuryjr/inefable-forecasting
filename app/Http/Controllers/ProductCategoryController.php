<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use \App\Models\ProductCategory;
use \App\Http\Requests\StoreProductCategoryRequest;
use \App\Http\Requests\UpdateProductCategoryRequest;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategories = ProductCategory::withCount('products')
            ->orderBy('id', 'ASC')
            ->get();

        return view('pages.dashboard.product-categories.index', [
            'productCategories' => $productCategories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.product-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductCategoryRequest $request)
    {
        ProductCategory::create($request->validated());

        return to_route('productCategories.index')->with([
            'response' => [
                'success' => true,
                'message' => "Kategori Produk berhasil ditambahkan"
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        return view('pages.dashboard.product-categories.edit', [
            'productCategory' => $productCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $productCategory->update($request->validated());

        return to_route('productCategories.index')->with([
            'response' => [
                'success' => true,
                'message' => 'Kategori produk berhasil diperbaharui'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        return response()->json([
            'success' => $productCategory->delete()
        ]);
    }

    public function getCategoryProducts(Request $request)
    {
        $categoryId = $request->id;

        // Fetch the products for the given category
        $products = Product::where('product_category_id', $categoryId)->get(['nama_produk']);

        // Return response as JSON
        return response()->json([
            'products' => $products
        ]);
    }
}
