<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $findProductCategoryResult = ProductCategory::where('nama_kategori', $row[2]);

            if (!$findProductCategoryResult) {
                $createProductCategoryResult = ProductCategory::create([
                    'nama_kategori' => $row[2]
                ]);
            }

            Product::create([
                'name' => $row[1],
                'product_category_id' => $createProductCategoryResult->id,
                'kode_produk' => $row[0],
                'warna' => $row[3],
                'variasi' => $row[4]
            ]);
        }
    }
}
