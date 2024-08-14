<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Petugas;
use App\Models\Sales;
use App\Models\StokBarang_Cluster;
use App\Models\StokBarang_Depo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalbarang = Barang::count();
        $totalpetugas = Petugas::count();
        $totalsales = Sales::count();
        $stokcluster = StokBarang_Cluster::sum('stok');
        $stokdepo = StokBarang_Depo::sum('stok');
        return view('admin.index', compact('totalbarang', 'totalpetugas', 'totalsales', 'stokcluster', 'stokdepo'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $barang = Barang::where('nama', 'LIKE', "%{$query}%")->get();
        $petugas = Petugas::where('nama', 'LIKE', "%{$query}%")->get();
        $sales = Sales::where('nama', 'LIKE', "%{$query}%")->get();

        return view('admin.search_results', compact('barang', 'petugas', 'sales', 'query'));
    }
}
