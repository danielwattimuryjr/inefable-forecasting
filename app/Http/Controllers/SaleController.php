<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Product;
use App\Models\Sale;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::withSum('sales', 'jumlah_penjualan')
            ->get();

        return view('pages.dashboard.sales.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('nama_produk', 'ASC')
            ->get(['id', 'nama_produk', 'kode_produk']);

        return view('pages.dashboard.sales.create', [
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        Sale::create($request->validated());

        return to_route('products.show', $request->product_id)->with([
            'response' => [
                'success' => true,
                'message' => 'Data penjualan produk berhasil ditambahkan'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $products = Product::orderBy('nama_produk', 'ASC')
            ->get(['id', 'nama_produk', 'kode_produk']);

        return view('pages.dashboard.sales.edit', [
            'sale' => $sale,
            'products' => $products
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        $sale->update($request->validated());

        return to_route('products.show', $request->product_id)->with([
            'response' => [
                'success' => true,
                'message' => 'Data penjualan produk berhasil diperbaharui'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        return response()->json([
            'success' => $sale->delete()
        ]);
    }
}
