<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\depo;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function index()
    {
        // $data = Sales::orderBy('nama', 'asc')->get();
        // return response()->json([
        //     'status' => true,
        //     'message' => 'Data Sales Ditemukan',
        //     'data' => $data
        // ], 200);
        $data = Sales::leftJoin('depo', 'depo.id', '=', 'sales.id_depo')
            ->select('sales.id', 'sales.nama', 'sales.email', 'depo.nama as nama_depo')
            ->orderBy('sales.id', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data Sales Ditemukan dengan Informasi depo',
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

        $dataSales = new Sales;

        $rules = [
            'nama' => 'required',
            'email' => 'required',
            'id_depo' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data Sales',
                'data' => $validator->errors()
            ]);
        }

        $dataSales->nama = $request->nama;
        $dataSales->email = $request->email;
        $dataSales->password = Hash::make($request->password);
        $dataSales->id_depo = $request->id_depo;


        $post = $dataSales->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses memasukkan data Sales'
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
        $data = Sales::leftJoin('depo', 'depo.id', '=', 'sales.id_depo')
            ->select('sales.id', 'sales.nama', 'sales.email', 'depo.nama as nama_depo')
            ->orderBy('sales.id', 'asc')
            ->find($id);

        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data Sales ditemukan',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data Sales tidak ditemukan'
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

        $dataSales = Sales::leftJoin('depo', 'depo.id', '=', 'sales.id_depo')
            ->select('sales.id', 'sales.nama', 'sales.email', 'depo.nama as nama_depo')
            ->orderBy('sales.id', 'asc')
            ->find($id);

        $dataSales = Sales::find($id);

        if (empty($dataSales)) {
            return response()->json([
                'status' => false,
                'message' => 'Data Sales tidak ditemukan'
            ], 404);
        }

        $rules = [
            'nama' => 'required',
            'email' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal melakukan UPDATE data Sales',
                'data' => $validator->errors()
            ]);
        }

        $dataSales->nama = $request->nama;
        $dataSales->email = $request->email;
        $dataSales->id_depo = $request->id_depo;

        $post = $dataSales->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan UPDATE data Sales'
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
        $dataSales = Sales::find($id);

        if (empty($dataSales)) {
            return response()->json([
                'status' => false,
                'message' => 'Data Sales tidak ditemukan'
            ], 404);
        }

        $post = $dataSales->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan DELETE data Sales'
        ]);
    }
}
