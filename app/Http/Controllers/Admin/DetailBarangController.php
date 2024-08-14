<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\DetailBarang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DetailBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = DetailBarang::with('barang', 'barang_masuk')->get();
        $barang = Barang::all();
        $barang_masuk = BarangMasuk::all();
        return view('admin.detail_barang.index', compact('data', 'barang', 'barang_masuk'));
    }

    public function create()
    {
        $data = DetailBarang::all();
        $nama_barang = Barang::all();
        $barang_masuk = BarangMasuk::all();
        return view('admin.detail_barang.create', compact('data', 'barang_masuk', 'nama_barang'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_barang' => 'required|numeric',
            'id_barang_masuk' => 'required|numeric',
            'kode_unik' => 'required|numeric',
            'status' => ['required', Rule::in([1, 0])]
        ]);

        DetailBarang::create($validatedData);

        return redirect()->route('admin.detail_barang')->with('success', 'Detail barang telah ditambahkan');
    }

    public function edit($id)
    {
        $data = DetailBarang::findOrFail($id);
        $nama_barang = Barang::all();
        $barang_masuk = BarangMasuk::all();
        return view('admin.detail_barang.edit', compact('data', 'nama_barang', 'barang_masuk'));
    }

    public function update(Request $request, $id)
    {
        $detailBarang = DetailBarang::findOrFail($id);

        $validatedData = $request->validate([
            'id_barang' => 'required|numeric',
            'id_barang_masuk' => 'required|numeric',
            'kode_unik' => 'required|numeric',
            'status' => ['required', Rule::in([1, 0])],
        ]);

        $detailBarang->update($validatedData);

        return redirect()->route('admin.detail_barang')->with('success', 'Detail barang telah diubah');
    }

    public function destroy($id)
    {
        $detailBarang = DetailBarang::findOrFail($id);
        $detailBarang->delete();

        return redirect()->route('admin.detail_barang')->with('success', 'Detail barang telah dihapus');
    }
}
