<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClusterController extends Controller
{
    public function index()
    {
        $data = Cluster::orderBy('nama', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data cluster Ditemukan',
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

        $dataCluster = new Cluster;

        $rules = [
            'nama' => 'required',
            'alamat' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data Cluster',
                'data' => $validator->errors()
            ]);
        }

        $dataCluster->nama = $request->nama;
        $dataCluster->alamat = $request->alamat;
        

        $post = $dataCluster->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses memasukkan data Cluster'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Cluster::find($id);

        if($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data Cluster ditemukan',
                'data' => $data
            ], 200);
        } else{
            return response()->json([
                'status' => false,
                'message' => 'Data Cluster tidak ditemukan'
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

        $dataCluster = Cluster::find($id);

        if(empty($dataCluster)){
            return response()->json([
                'status' => false,
                'message' => 'Data Cluster tidak ditemukan'
            ], 404);
        }

        $rules = [
            'nama' => 'required',
            'alamat' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal melakukan UPDATE data Cluster',
                'data' => $validator->errors()
            ]);
        }

        $dataCluster->nama = $request->nama;
        $dataCluster->alamat = $request->alamat;

        $post = $dataCluster->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan UPDATE data Cluster'
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
        $dataCluster = Cluster::find($id);

        if(empty($dataCluster)){
            return response()->json([
                'status' => false,
                'message' => 'Data Cluster tidak ditemukan'
            ], 404);
        }

        $post = $dataCluster->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan DELETE data Cluster'
        ]);
    }
}
