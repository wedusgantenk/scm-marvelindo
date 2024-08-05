<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisOutlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisOutletController extends Controller
{
    public function index()
    {
        $data = JenisOutlet::orderBy('nama', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data JenisOutlet Ditemukan',
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

        $dataJenisOutlet = new JenisOutlet;

        $rules = [
            'nama' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data JenisOutlet',
                'data' => $validator->errors()
            ]);
        }

        $dataJenisOutlet->nama = $request->nama;
        

        $post = $dataJenisOutlet->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses memasukkan data JenisOutlet'
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
        $data = JenisOutlet::find($id);

        if($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data JenisOutlet ditemukan',
                'data' => $data
            ], 200);
        } else{
            return response()->json([
                'status' => false,
                'message' => 'Data JenisOutlet tidak ditemukan'
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

        $dataJenisOutlet = JenisOutlet::find($id);

        if(empty($dataJenisOutlet)){
            return response()->json([
                'status' => false,
                'message' => 'Data JenisOutlet tidak ditemukan'
            ], 404);
        }

        $rules = [
            'nama' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal melakukan UPDATE data JenisOutlet',
                'data' => $validator->errors()
            ]);
        }

        $dataJenisOutlet->nama = $request->nama;

        $post = $dataJenisOutlet->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan UPDATE data JenisOutlet'
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
        $dataJenisOutlet = JenisOutlet::find($id);

        if(empty($dataJenisOutlet)){
            return response()->json([
                'status' => false,
                'message' => 'Data JenisOutlet tidak ditemukan'
            ], 404);
        }

        $post = $dataJenisOutlet->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan DELETE data JenisOutlet'
        ]);
    }
}
