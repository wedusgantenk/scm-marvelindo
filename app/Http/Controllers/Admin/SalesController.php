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
        ]
    );

    Sales::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'id_depo' => $request->id_depo,
        'area' => $request->area,
        'password' => $request->password, // Hash the password
        'status' => $request->status,
    ]);

    return redirect()->route('admin.sales')->with('success', 'Sales ' . $request->nama . ' telah ditambahkan');
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

    $data = [
        'nama' => $request->nama,
        'email' => $request->email,
        'area' => $request->area,
        'status' => $request->status,
        'id_depo' => $request->id_depo,
    ];

    if ($request->filled('password')) {
        $data['password'] = $request->password; // Hash the password if it's updated
    }

    $sales->update($data);

    return redirect()->route('admin.sales')->with('success', 'Sales telah diubah');
}

    public function destroy($id)
    {
        $sales = Sales::findOrFail($id);
        $sales->delete();
        return redirect()->route('admin.sales')->with('success', 'Sales telah dihapus');
    }
}
