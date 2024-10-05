<?php

namespace App\Exports;

use App\Models\Forecast;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\BeforeSheet;

class ForecastsExport implements FromQuery, WithHeadings, ShouldAutoSize, WithEvents
{
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet
                    ->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            },
        ];
    }
    public function headings(): array
    {
        return [
            'Nama Produk',
            'Ukuran',
            'Periode',
            'Prediksi',
            'Tanggal Prediksi',
        ];
    }

    public function query()
    {
        return Forecast::query()
            ->from('forecasts')
            ->join('products', 'forecasts.product_id', '=', 'products.id')
            ->select([
                'products.nama_produk',
                'products.variasi',
                'forecasts.periode',
                'forecasts.value',
                'forecasts.created_at'
            ])
            ->orderBy('forecasts.periode', 'desc')
            ->orderBy('products.nama_produk', 'asc');
        ;
    }
}
