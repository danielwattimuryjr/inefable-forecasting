<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jenis = ProductCategory::select('product_categories.*', DB::raw('
    (SELECT COUNT(DISTINCT nama_produk) 
     FROM products 
     WHERE products.product_category_id = product_categories.id) AS product_count
'))->get();
        return view('pages.dashboard.index', [
            'jenis' => $jenis
        ]);
    }
}
