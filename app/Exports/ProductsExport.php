<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Product::with('productCategory')->query();
    }

    public function map($product) : array {
        return [
            $product->kode_produk,
            $product->nama_produk,
            $product->productCategory->nama_kategori,
            $product->warna,
            $product->variasi
        ];
    }

    public function headings() : array {
        return [
            'Kode Produk',
            'Nama Produk',
            'Kategori Produk',
            'Warna',
            'Varias'
        ];
    }
}
