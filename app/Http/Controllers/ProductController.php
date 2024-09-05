<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use \App\Http\Requests\StoreProductRequest;
use \App\Http\Requests\UpdateProductRequest;
use \App\Models\Product;
use \App\Models\ProductCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(
            'productCategory'
        )->orderBy('id', 'ASC')->get();

        return view('pages.dashboard.products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCategories = ProductCategory::orderBy('id')
            ->get();

        return view('pages.dashboard.products.create', [
            'productCategories' => $productCategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return to_route('products.index')->with([
            'success' => true,
            'message' => 'Product Berhasil ditambahkan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('pages.dashboard.products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $productCategories = ProductCategory::orderBy('id')
            ->get();

        return view('pages.dashboard.products.edit', [
            'product' => $product,
            'productCategories' => $productCategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return to_route('products.index')->with([
            'success' => true,
            'message' => 'Product Berhasil diperbaharui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return response()->json([
            'success' => $product->delete()
        ]);
    }
}
