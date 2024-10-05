<?php

namespace App\Http\Controllers;

use App\Exports\ForecastsExport;
use App\Exports\ProductCategoryExport;
use App\Exports\ProductsExport;
use App\Exports\SalesExport;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function salesExport()
    {
        $timestamp = Carbon::now()->format('Y-m-d_His');
        $fileName = $timestamp . '_sales_report.xlsx';

        return Excel::download(new SalesExport, $fileName);
    }

    public function forecastsExport()
    {
        $timestamp = Carbon::now()->format('Y-m-d_His');
        $fileName = $timestamp . '_forecasts_report.pdf';

        return Excel::download(new ForecastsExport, $fileName, \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
