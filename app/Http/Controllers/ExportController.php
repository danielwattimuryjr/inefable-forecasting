<?php

namespace App\Http\Controllers;

use App\Exports\ProductCategoryExport;
use App\Exports\ProductsExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    
    public function productsExport () 
    {
        $timestamp = Carbon::now()->format('Y-m-d_His');
        $fileName = $timestamp . '_products.xlsx';

        return Excel::download(new ProductsExport, $fileName);
    }

    public function productCategoriesExport () 
    {
        $timestamp = Carbon::now()->format('Y-m-d_His');
        $fileName = $timestamp . '_product_categories.xlsx';

        return Excel::download(new ProductCategoryExport, $fileName);
    }
}
