<?php

namespace App\Http\Controllers;

use App\Imports\ProductCategoriesImport;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function productsImport(Request $request) {
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,xlsx' ,'extensions:pdf,xlsx']
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        return back()->with('response', [
            'success' => true,
            'message' => "Data produk berhasil diimport",
        ]);
    }

    public function productCategoriesImport(Request $request) {
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,xlsx' ,'extensions:pdf,xlsx']
        ]);

        Excel::import(new ProductCategoriesImport, $request->file('file'));

        return back()->with('response', [
            'success' => true,
            'message' => "Data produk berhasil diimport",
        ]);
    }
}
