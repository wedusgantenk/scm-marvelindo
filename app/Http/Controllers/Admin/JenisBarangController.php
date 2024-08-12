<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisBarang;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = JenisBarang::all();
        return view('admin.jenis_barang.index', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|unique:jenis_barang',
            ],
            [
                'nama.required' => 'Nama jenis barang harus diisi',
                'nama.unique' => 'Jenis barang sudah ada',
            ]
        );

        JenisBarang::create([
            'nama' => $request->nama,
        ]);

        return response()->json(['message' => 'Jenis barang telah ditambahkan'], 200);
    }

    public function update(Request $request, $id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);

        $request->validate(
            [
                'nama' => 'required|unique:jenis_barang,nama,' . $id,
            ],
            [
                'nama.required' => 'Nama jenis barang harus diisi',
                'nama.unique' => 'Jenis barang sudah ada',
            ]
        );

        $jenisBarang->update([
            'nama' => $request->nama,
        ]);

        return response()->json(['message' => 'Jenis barang telah diubah'], 200);
    }

    public function destroy($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);
        $jenisBarang->delete();

        return response()->json(['message' => 'Jenis barang telah dihapus'], 200);
    }
}
