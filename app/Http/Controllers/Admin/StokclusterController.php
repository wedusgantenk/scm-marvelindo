<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Cluster;
use App\Models\StokBarang_Cluster;
use Illuminate\Http\Request;
use App\DataTables\StokclusterDataTable;

use function Termwind\render;

class StokclusterController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = StokBarang_Cluster::with('cluster')->get(); //'barang'
        return view('admin.stok_barang.cluster.index', compact('data'));
    }
    public function create()
    {
        $data = StokBarang_Cluster::all();
        $cluster = Cluster::all();
        //$barang = Barang::all();

        return view('admin.stok_barang.cluster.create', compact('data', 'cluster')); //'barang'
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_cluster' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        // Ambil data stok saat ini berdasarkan id_cluster
        $stokBarangCluster = StokBarang_Cluster::where('id_cluster', $request->id_cluster)->first();

        // Jika data stok sudah ada, tambahkan stok baru
        if ($stokBarangCluster) {
            $stokBarangCluster->stok += $request->stok;
            $stokBarangCluster->save();
        } else {
            // Jika belum ada data stok, buat data baru
            StokBarang_Cluster::create([
                'id_cluster' => $request->id_cluster,
                'stok' => $request->stok
            ]);
        }

        return redirect()->route('admin.stok_barang.cluster')->with('success', 'Data stok barang telah ditambahkan');
    }

    public function edit($id)
    {
        $data = StokBarang_Cluster::findOrFail($id);
        $cluster = Cluster::all();
        return view('admin.stok_barang.cluster.edit', compact('data', 'cluster'));
    }
    public function update(Request $request, $id)
    {
        $data = StokBarang_Cluster::find($id);
        $request->validate(
            [
                'id_cluster' => 'required|numeric',
                'stok' => 'required|numeric',
            ]
        );
        $data = StokBarang_Cluster::findOrFail($id);
        $data->update(
            [
                //'id_barang' => $request->id_barang,
                'id_cluster' => $request->id_cluster,
                'stok' => $request->stok,
            ]
        );
        return redirect()->route('admin.stok_barang.cluster')->with('success', 'stok barang telah diubah');
    }
    public function destroy($id)
    {
        StokBarang_Cluster::find($id)->delete();
        return redirect()->route('admin.stok_barang.cluster')->with('success', 'stok barang telah dihapus');
    }
}
