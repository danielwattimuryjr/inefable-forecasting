<?php

namespace App\Exports;

use App\Models\ProductCategory;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductCategoryExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    
    public function query()
    {
        return ProductCategory::all();
    }

    public function map($productCategory) : array {
        return [
            $productCategory->nama_kategori,
        ];
    }

    public function headings() : array {
        return [
            'Kategori Produk',
        ];
    }
}
