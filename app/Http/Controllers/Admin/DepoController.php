<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Models\Cluster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->hak_akses == "cluster") {
            $idCluster = Auth::user()->jenis;
            $data = Depo::with('cluster')->where('id_cluster', $idCluster)->get();
            $clusters = Cluster::all();
        } else {
            $data = Depo::with('cluster')->get();
            $clusters = Cluster::all();
        }
        return view('admin.depo.index', ['data' => $data, 'clusters' => $clusters]);
    }

    public function store(Request $request)
    {
        
        if (Auth::user()->hak_akses == "cluster") {
            $request->validate(
                [
                    'nama' => 'required|unique:depo',                    
                    'alamat' => 'required',
                ],
                [
                    'nama.required' => 'Nama depo harus diisi',
                    'nama.unique' => 'Depo sudah ada',                    
                    'alamat.required' => 'Alamat depo harus diisi',
                ]
            );

            $depo = new Depo();
            $depo->nama = $request->nama;
            $depo->id_cluster = Auth::user()->jenis;
            $depo->alamat = $request->alamat;
            $depo->save();
        } else {
            $request->validate(
                [
                    'nama' => 'required|unique:depo',
                    'id_cluster' => 'required',
                    'alamat' => 'required',
                ],
                [
                    'nama.required' => 'Nama depo harus diisi',
                    'nama.unique' => 'Depo sudah ada',
                    'id_cluster.required' => 'Cluster harus dipilih',
                    'alamat.required' => 'Alamat depo harus diisi',
                ]
            );

            $depo = new Depo();
            $depo->nama = $request->nama;
            $depo->id_cluster = $request->id_cluster;
            $depo->alamat = $request->alamat;
            $depo->save();
        }                        

        return response()->json(['success' => true, 'message' => 'Depo berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $depo = Depo::find($id);
        $depo->nama = $request->nama;
        $depo->id_cluster = $request->id_cluster;
        $depo->alamat = $request->alamat;
        $depo->save();

        return response()->json(['success' => true, 'message' => 'Depo berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $depo = Depo::findOrFail($id);
        $depo->delete();

        return response()->json(['success' => true, 'message' => 'Depo berhasil dihapus']);
    }
}

