<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Models\StokBarang_Depo;
use Illuminate\Http\Request;

class StokdepoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = StokBarang_Depo::all(); //'barang'
        return view('admin.stok_barang.depo.index', compact('data'));
    }
    public function create()
    {
        $data = StokBarang_Depo::all();
        $depo = Depo::all();
        //$barang = Barang::all();

        return view('admin.stok_barang.depo.create', compact('data', 'depo')); //'barang'
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                //'id_barang' => 'required|numeric',
                'id_depo' => 'required',
                'stok' => 'required|numeric',
            ]
        );
        StokBarang_Depo::create([
            //'id_barang' => $request->id_barang,
            'id_depo' => $request->id_depo,
            'stok' => $request->stok
        ]);
        return redirect()->route('admin.stok_barang.depo')->with('success', 'data stok barang telah ditambahkan');
    }
    public function edit($id)
    {
        $data = StokBarang_Depo::findOrFail($id);
        $depo = Depo::all();
        return view('admin.stok_barang.depo.edit', compact('data', 'depo'));
    }
    public function update(Request $request, $id)
    {
        $data = StokBarang_Depo::find($id);
        $request->validate(
            [
                'id_depo' => 'required',
                'stok' => 'required|numeric',
            ]
        );
        $data = StokBarang_Depo::findOrFail($id);
        $data->update(
            [
                //'id_barang' => $request->id_barang,
                'id_depo' => $request->id_depo,
                'stok' => $request->stok
            ]
        );
        return redirect()->route('admin.stok_barang.depo')->with('success', 'stok barang telah diubah');
    }
    public function destroy($id)
    {
        StokBarang_Depo::find($id)->delete();
        return redirect()->route('admin.stok_barang.depo')->with('success', 'stok barang telah dihapus');
    }
}
