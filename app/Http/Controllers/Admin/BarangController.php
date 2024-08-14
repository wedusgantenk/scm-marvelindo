<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\BarangImport;
use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jenis_barang = JenisBarang::all();
        $data = Barang::all();
        return view('admin.barang.index', compact('data', 'jenis_barang'));
    }

    public function create()
    {
        $jenis_barang = JenisBarang::all();
        return view('admin.barang.create', compact('jenis_barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:barang',
            'id_jenis' => 'required|numeric',
            'fisik' => ['in:1,0'],
        ], [
            'nama.required' => 'Nama barang harus diisi',
            'nama.unique' => 'Barang sudah ada',
            'id_jenis.required' => 'Jenis barang harus dipilih',
            'id_jenis.numeric' => 'Jenis barang harus berupa angka',
        ]);

        $filename = 'no_image.jpg';
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move('images/barang', $filename);
        }

        Barang::create([
            'nama' => $request->nama,
            'id_jenis' => $request->id_jenis,
            'gambar' => $filename,
            'fisik' => $request->has('fisik') ? $request->fisik : 0,
            'keterangan' => $request->keterangan,
        ]);
        return redirect()->route('admin.barang')->with('success', 'Barang telah ditambahkan');
    }

    public function edit($id)
    {
        $data = Barang::findOrFail($id);
        $jenis_barang = JenisBarang::all();
        return view('admin.barang.edit', compact('data', 'jenis_barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $request->validate([
            'nama' => 'required|unique:barang,nama,' . $id,
            'id_jenis' => 'required|numeric',
            'fisik' => ['in:1,0']
        ], [
            'nama.required' => 'Nama barang harus diisi',
            'nama.unique' => 'Nama barang sudah ada',
            'id_jenis.required' => 'Jenis barang harus dipilih',
            'id_jenis.numeric' => 'Jenis barang harus dipilih',
        ]);

        $filename = $barang->gambar;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move('images/barang', $filename);
        }

        $barang->update([
            'nama' => $request->nama,
            'id_jenis' => $request->id_jenis,
            'gambar' => $filename,
            'fisik' => $request->has('fisik') ? $request->fisik : 0,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.barang')->with('success', 'Barang telah diubah');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('admin.barang')->with('success', 'Barang telah dihapus');
    }

    public function import()
    {
        return view('admin.barang.import');
    }

    public function import_excel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');
        $nama_file = uniqid() . '_' . $file->getClientOriginalName();
        $file->move(public_path('file_barang'), $nama_file);

        Excel::import(new BarangImport, public_path('file_barang/' . $nama_file));

        return redirect()->route('admin.barang')->with('success', 'Barang telah ditambahkan');
    }

    public function export()
    {
        $file = time() . 'data-barang.xlsx';
        return (new FastExcel(Barang::all()))->download($file, function ($barang) {
            return [
                'nama' => $barang->nama,
                'alamat' => $barang->alamat,
                'id_jenis' => $barang->id_jenis,
                'fisik' => $barang->fisik,
                'keterangan' => $barang->keterangan,
            ];
        });
    }
}
