<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailBarang;
use App\Models\Cluster;
use App\Models\Depo;
use App\Models\HistoriBarang;
use App\Models\ViewHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoriBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (Auth::user()->hak_akses == "cluster") {
            $idCluster = Auth::user()->jenis;
            $cluster = Cluster::where('id', $idCluster)->first();
            $kode_cluster = $cluster ? $cluster->kode_cluster : null;
            $detailBarangIds = DetailBarang::whereHas('barang_masuk', function ($query) use ( $kode_cluster) {
                $query->where('kode_cluster',  $kode_cluster);
            })->pluck('kode_unik');

            $data = ViewHistory::with(['detail_barang', 'lokasi_asal', 'lokasi_tujuan'])
                ->whereIn('id_detail_barang', $detailBarangIds)
                ->get();
        } else {
            $data = ViewHistory::with(['detail_barang', 'lokasi_asal', 'lokasi_tujuan'])->get();
        }

        $detail_barang = DetailBarang::all();
        $cluster = Cluster::all();
        $depo = Depo::all();

        return view('admin.histori_barang.index', compact('data', 'detail_barang', 'cluster', 'depo'));
    }

    public function create()
    {
        $detail_barang = DetailBarang::all();
        $cluster = Cluster::all();
        $depo = Depo::all();

        return view('admin.histori_barang.create', compact('detail_barang', 'cluster', 'depo'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'id_detail_barang' => 'required|numeric',
                'type' => 'required',
                'id_lokasi_asal' => 'required|numeric',
                'id_lokasi_tujuan' => 'required|numeric',
                'tanggal' => 'required',
            ],
            [
                'id_detail_barang.required' => 'Detail barang harus diisi',
                'type.required' => 'Tipe harus diisi',
                'id_lokasi_asal.required' => 'Lokasi asal barang harus diisi',
                'id_lokasi_tujuan.required' => 'Lokasi tujuan barang harus diisi',
                'tanggal.required' => 'tanggal pengiriman harus diisi',
            ]
        );

        ViewHistory::create($request->all());

        return redirect()->route('admin.histori_barang')->with('success', 'histori barang telah ditambahkan');
    }

    public function edit($id)
    {
        $data = ViewHistory::findOrFail($id);
        $detail_barang = DetailBarang::all();
        $cluster = Cluster::all();
        $depo = Depo::all();
        return view('admin.histori_barang.edit', compact('data', 'detail_barang', 'cluster', 'depo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'id_detail_barang' => 'required|numeric',
                'type' => 'required',
                'id_lokasi_asal' => 'required|numeric',
                'id_lokasi_tujuan' => 'required|numeric',
                'tanggal' => 'required',
            ],
            [
                'id_detail_barang.required' => 'Detail barang harus diisi',
                'type.required' => 'Tipe harus diisi',
                'id_lokasi_asal.required' => 'Lokasi asal barang harus diisi',
                'id_lokasi_tujuan.required' => 'Lokasi tujuan barang harus diisi',
                'tanggal.required' => 'tanggal pengiriman harus diisi',
            ]
        );

        $historiBarang = ViewHistory::findOrFail($id);
        $historiBarang->update($request->all());

        return redirect()->route('admin.histori_barang')->with('success', 'histori telah diubah');
    }

    public function destroy($id)
    {
        $historiBarang = ViewHistory::findOrFail($id);
        $historiBarang->delete();

        return redirect()->route('admin.histori_barang')->with('success', 'histori telah dihapus');
    }
}
