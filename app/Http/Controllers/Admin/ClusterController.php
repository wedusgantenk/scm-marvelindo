<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ClusterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Cluster::all();
        return view('admin.cluster.index', ['data' => $data]);
    }

    public function create()
    {
        return view('admin.cluster.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|unique:cluster',
                'kode_cluster' => 'required|unique:cluster',
            ],
            [
                'nama.required' => 'Nama cluster harus diisi',
                'nama.unique' => 'cluster sudah ada',
                'kode_cluster.required' => 'kode cluster harus diisi',
                'kode_cluster.unique' => 'kode cluster sudah ada',
            ]
        );

        $cluster = new Cluster();
        $cluster->kode_cluster = $request->kode_cluster;
        $cluster->nama = $request->nama;
        $cluster->alamat = $request->alamat;
        $cluster->save();

        return redirect()->back();
    }


    public function update(Request $request, $id)
    {
        $cluster = Cluster::find($id);
        $cluster->kode_cluster = $request->kode_cluster;
        $cluster->nama = $request->nama;
        $cluster->alamat = $request->alamat;
        $cluster->save();
        return redirect()->back();
    }

    public function destroy($id)
    {
        $cluster = Cluster::findOrFail($id);
        $cluster->delete();

        return response()->json(['success' => true, 'message' => 'Cluster berhasil dihapus']);
    }

    public function export()
    {
        $file = time() . 'data-warehouse.xlsx';
        return (new FastExcel(Cluster::all()))->download($file, function ($cluster) {
            return [
                'kode_cluster' => $cluster->kode_cluster,
                'nama' => $cluster->nama,
                'alamat' => $cluster->alamat,
            ];
        });
    }
}
