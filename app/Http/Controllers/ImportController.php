<?php

namespace App\Http\Controllers;

use App\Imports\SalesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function salesImport(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,xlsx', 'extensions:pdf,xlsx']
        ]);

        Excel::import(new SalesImport, $request->file('file'));

        return back()->with('response', [
            'success' => true,
            'message' => "Data penjualan berhasil diimport",
        ]);
    }
}
