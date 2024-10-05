<?php

namespace App\Exports;

use App\Models\Sale;
use DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromView, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): \Illuminate\Contracts\View\View
    {
        return view('exports.sales', [
            'salesData' => DB::table('sales as s')
                ->join('products as p', 's.product_id', '=', 'p.id')
                ->join('product_categories as pc', 'p.product_category_id', '=', 'pc.id')
                ->select(
                    'p.nama_produk',
                    'p.kode_produk',
                    'p.variasi',
                    'p.warna',
                    'pc.nama_kategori',  // Assuming 'nama_kategori' is the category name column in product_categories
                    DB::raw('
            JSON_ARRAYAGG(
                JSON_OBJECT(
                    "periode_penjualan", s.periode_penjualan,
                    "jumlah_penjualan", s.jumlah_penjualan
                )
            ) AS sales
        ')
                )
                ->groupBy('p.nama_produk', 'pc.nama_kategori', 'p.kode_produk', 'p.variasi', 'p.warna')
                ->get()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1:H1000' => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}
