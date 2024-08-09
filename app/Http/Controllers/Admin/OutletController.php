<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bts;
use App\Models\Outlet;
use App\Models\JenisOutlet;
use App\Models\Depo;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $jenisOutlet = JenisOutlet::all();
        $bts = Bts::all();
        $depo = Depo::all();
        $data = Outlet::with(['bts', 'jenisOutlet', 'depo'])->get();
        return view('admin.outlet.index', compact('data', 'jenisOutlet', 'bts', 'depo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:outlets',
            'bts_id' => 'required|exists:bts,id',
            'jenis_id' => 'required|exists:jenis_outlets,id',
            'depo_id' => 'required|exists:depos,id',
        ], [
            'nama.required' => 'Nama outlet harus diisi',
            'nama.unique' => 'Outlet sudah ada',
            'bts_id.required' => 'BTS harus dipilih',
            'bts_id.exists' => 'BTS tidak valid',
            'jenis_id.required' => 'Jenis harus dipilih',
            'jenis_id.exists' => 'Jenis tidak valid',
            'depo_id.required' => 'Depo harus dipilih',
            'depo_id.exists' => 'Depo tidak valid',
        ]);

        Outlet::create($request->all());

        return redirect()->route('admin.outlet')->with('success', 'Outlet telah ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $outlet = Outlet::findOrFail($id);

        $request->validate([
            'nama' => 'required|unique:outlets,nama,' . $id,
            'bts_id' => 'required|exists:bts,id',
            'jenis_id' => 'required|exists:jenis_outlets,id',
            'depo_id' => 'required|exists:depos,id',
        ], [
            'nama.required' => 'Nama outlet harus diisi',
            'nama.unique' => 'Nama outlet sudah ada',
            'bts_id.required' => 'BTS harus dipilih',
            'bts_id.exists' => 'BTS tidak valid',
            'jenis_id.required' => 'Jenis harus dipilih',
            'jenis_id.exists' => 'Jenis tidak valid',
            'depo_id.required' => 'Depo harus dipilih',
            'depo_id.exists' => 'Depo tidak valid',
        ]);

        $outlet->update($request->all());

        return redirect()->route('admin.outlet')->with('success', 'Outlet telah diubah');
    }

    public function destroy($id)
    {
        $outlet = Outlet::findOrFail($id);
        $outlet->delete();

        return redirect()->route('admin.outlet')->with('success', 'Outlet telah dihapus');
    }
}
