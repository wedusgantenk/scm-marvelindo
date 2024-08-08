<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Sales::with('depo')->get();
        $depo = Depo::all();
        return view('admin.sales.index', ['data' => $data, 'depo' => $depo]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required',
                'email' => 'required|email|unique:sales,email',
                'id_depo' => 'required',
                'area' => 'required',
                'password' => 'required|min:6',
                'status' => 'required',
            ], [
                'nama.required' => 'Nama harus diisi!',
                'email.required' => 'Email harus diisi!',
                'email.email' => 'Email tidak valid!',
                'email.unique' => 'Email sudah terdaftar!',
                'id_depo.required' => 'Depo harus dipilih!',
                'area.required' => 'Area harus diisi!',
                'password.required' => 'Password harus diisi!',
                'password.min' => 'Password minimal 6 karakter!',
                'status.required' => 'Status harus diisi!',
            ]
        );

        Sales::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'id_depo' => $request->id_depo,
            'area' => $request->area,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.sales.index')->with('success', 'Sales ' . $request->nama . ' telah ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:sales,email,' . $id,
            'area' => 'required',
            'password' => 'nullable|min:6',
            'status' => 'required',
            'id_depo' => 'required',
        ]);

        $sales = Sales::findOrFail($id);

        $sales->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'area' => $request->area,
            'status' => $request->status,
            'id_depo' => $request->id_depo,
            'password' => $request->password ? Hash::make($request->password) : $sales->password,
        ]);

        return redirect()->route('admin.sales.index')->with('success', 'Sales telah diubah');
    }

    public function destroy($id)
    {
        $sales = Sales::findOrFail($id);
        $sales->delete();
        return redirect()->route('admin.sales.index')->with('success', 'Sales telah dihapus');
    }
}
