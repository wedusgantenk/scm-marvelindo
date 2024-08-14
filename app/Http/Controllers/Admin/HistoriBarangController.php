<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailBarang;
use App\Models\Cluster;
use App\Models\Depo;
use App\Models\HistoriBarang;
use Illuminate\Http\Request;

class HistoriBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = HistoriBarang::with(['detail_barang', 'lokasi_asal', 'lokasi_tujuan'])->get();
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

        HistoriBarang::create($request->all());

        return redirect()->route('admin.histori_barang')->with('success', 'histori barang telah ditambahkan');
    }

    public function edit($id)
    {
        $data = HistoriBarang::findOrFail($id);
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

        $historiBarang = HistoriBarang::findOrFail($id);
        $historiBarang->update($request->all());

        return redirect()->route('admin.histori_barang')->with('success', 'histori telah diubah');
    }

    public function destroy($id)
    {
        $historiBarang = HistoriBarang::findOrFail($id);
        $historiBarang->delete();

        return redirect()->route('admin.histori_barang')->with('success', 'histori telah dihapus');
    }
}
