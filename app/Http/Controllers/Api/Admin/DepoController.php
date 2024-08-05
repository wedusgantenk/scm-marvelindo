<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Models\Cluster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepoController extends Controller
{
    // public function index() // testing 1 tanpa join
    // {
    //     $data = Depo::orderBy('id_cluster', 'asc')->get();
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Data Depo Ditemukan',
    //         'data' => $data
    //     ], 200);
        
    // }

//     public function index() //testing 2
// {
//     $data = Depo::join('cluster', 'cluster.id', '=', 'Depo.id_cluster')
//         ->select('Depo.*', 'cluster.nama as cluster_nama')
//         ->orderBy('Depo.id_cluster', 'asc')
//         ->get();

//     return response()->json([
//         'status' => true,
//         'message' => 'Data Depo Ditemukan dengan Informasi cluster',
//         'data' => $data
//     ], 200);
// }

public function index()
{
    $data = Depo::leftJoin('cluster', 'cluster.id', '=', 'depo.id_cluster')
        ->select('Depo.id', 'Depo.nama', 'Depo.alamat', 'cluster.nama as nama_cluster')
        ->orderBy('Depo.id', 'asc')
        ->get();

    return response()->json([
        'status' => true,
        'message' => 'Data Depo Ditemukan dengan Informasi cluster',
        'data' => $data
    ], 200);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $lastcluster = cluster::latest()->first();
        // if ($lastcluster) {
        // $clusterId = $lastcluster->id;
        // } else {
        //     return "";
        // }

        $dataDepo = new Depo;

        $rules = [
            'nama' => 'required',
            'alamat' => 'required',
            'id_cluster' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data Depo',
                'data' => $validator->errors()
            ]);
        }

        $dataDepo->nama = $request->nama;
        $dataDepo->alamat = $request->alamat;
        $dataDepo->id_cluster = $request->id_cluster;
        

        $post = $dataDepo->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses memasukkan data Depo'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) // jika ingin BY id ganti dengan $id
    {
        $data = Depo::leftJoin('cluster', 'cluster.id', '=', 'depo.id_cluster')
        ->select('depo.id', 'depo.nama', 'depo.alamat', 'cluster.nama as nama_cluster')
        ->orderBy('Depo.id', 'asc')
        ->find($id); // BY ID

        // $data = Depo::leftJoin('cluster', 'cluster.id', '=', 'Depo.id_cluster')
        // ->select('Depo.id', 'Depo.nama', 'Depo.alamat', 'cluster.nama as nama_cluster')
        // ->where('Depo.nama', $namaDepo)
        // ->first(); // BY NAMA

        if($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data Depo ditemukan',
                'data' => $data
            ], 200);
        } else{
            return response()->json([
                'status' => false,
                'message' => 'Data Depo tidak ditemukan'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $dataDepo = Depo::leftJoin('cluster', 'cluster.id', '=', 'Depo.id_cluster')
        ->select('Depo.id', 'Depo.nama', 'Depo.alamat', 'cluster.nama as nama_cluster')
        ->orderBy('Depo.id', 'asc')
        ->find($id);

        if(empty($dataDepo)){
            return response()->json([
                'status' => false,
                'message' => 'Data Depo tidak ditemukan'
            ], 404);
        }

        $rules = [
            // 'nama' => 'required',
            // 'alamat' => 'required',
            // 'alamat' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal melakukan UPDATE data Depo',
                'data' => $validator->errors()
            ]);
        }

        $dataDepo->nama = $request->nama;
        $dataDepo->alamat = $request->alamat;
        $dataDepo->id_cluster = $request->id_cluster;
        // $dataDepo->id_cluster = $clusterId;

        $post = $dataDepo->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan UPDATE data Depo'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataDepo = Depo::find($id);

        if(empty($dataDepo)){
            return response()->json([
                'status' => false,
                'message' => 'Data Depo tidak ditemukan'
            ], 404);
        }

        $post = $dataDepo->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan DELETE data Depo'
        ]);
    }
}
