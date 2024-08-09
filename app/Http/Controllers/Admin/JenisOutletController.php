<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisOutlet;
use Illuminate\Http\Request;

class JenisOutletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = JenisOutlet::all();
        return view('admin.jenis_outlet.index', ['data' => $data]);
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|unique:jenis_outlet',
            ],
            [
                'nama.required' => 'Nama jenis outlet harus diisi',
                'nama.unique' => 'Jenis outlet sudah ada',
            ]
        );

        JenisOutlet::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.jenis_outlet')->with('success', 'Jenis outlet telah ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $jenisOutlet = JenisOutlet::findOrFail($id);

        $request->validate(
            [
                'nama' => 'required|unique:jenis_outlet,nama,' . $id,
            ],
            [
                'nama.required' => 'Nama jenis outlet harus diisi',
                'nama.unique' => 'Jenis outlet sudah ada',
            ]
        );

        $jenisOutlet->update([
            'nama' => $request->nama,
        ]);

        return response()->json(['message' => 'Jenis outlet telah diubah', 'status' => 'success']);
    }

    public function destroy($id)
    {
        $jenisOutlet = JenisOutlet::findOrFail($id);
        $jenisOutlet->delete();

        return response()->json(['message' => 'Jenis outlet telah dihapus', 'status' => 'success']);
    }
}
