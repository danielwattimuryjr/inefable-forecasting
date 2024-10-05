<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class SalesImport implements ToModel, WithHeadingRow
{
    private $lastProductData = [];

    public function model(array $row)
    {
        if (!empty($row['nama_produk'])) {
            $this->lastProductData['nama_produk'] = $row['nama_produk'];
            $this->lastProductData['kode_produk'] = $row['kode_produk'];
            $this->lastProductData['variasi'] = $row['variasi'];
            $this->lastProductData['warna'] = $row['warna'];
            $this->lastProductData['kategori'] = $row['kategori'];
        }

        $namaProduk = $this->lastProductData['nama_produk'];
        $kodeProduk = $this->lastProductData['kode_produk'];
        $variasi = $this->lastProductData['variasi'];
        $warna = $this->lastProductData['warna'];
        $kategori = $this->lastProductData['kategori'];

        $category = ProductCategory::firstOrCreate(
            ['nama_kategori' => $kategori]
        );

        $product = Product::firstOrCreate(
            [
                'kode_produk' => $kodeProduk,
                'nama_produk' => $namaProduk,
                'variasi' => $variasi,
                'warna' => $warna,
            ],
            ['product_category_id' => $category->id]
        );

        return new Sale([
            'product_id' => $product->id,
            'periode_penjualan' => $row['periode_penjualan'],
            'jumlah_penjualan' => $row['jumlah_penjualan'],
        ]);
    }
}
