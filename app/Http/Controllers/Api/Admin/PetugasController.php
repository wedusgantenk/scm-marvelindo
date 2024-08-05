<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PetugasController extends Controller
{
    public function index()
    {
        $data = Petugas::orderBy('username', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data Petugas Ditemukan',
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

        $dataPetugas = new Petugas;

        $rules = [
            'username' => 'required',
            'password' => 'required',
            'jenis' => 'required',
            'bagian' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data Petugas',
                'data' => $validator->errors()
            ]);
        }

        $dataPetugas->username = $request->username;
        $dataPetugas->jenis = $request->jenis;
        $dataPetugas->bagian = $request->bagian;
        $dataPetugas->password = Hash::make($request->password);
        

        $post = $dataPetugas->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses memasukkan data Petugas'
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
        $data = Petugas::find($id);

        if($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data Petugas ditemukan',
                'data' => $data
            ], 200);
        } else{
            return response()->json([
                'status' => false,
                'message' => 'Data Petugas tidak ditemukan'
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

        $dataPetugas = Petugas::find($id);

        if(empty($dataPetugas)){
            return response()->json([
                'status' => false,
                'message' => 'Data Petugas tidak ditemukan'
            ], 404);
        }

        $rules = [
            'username' => 'required',
            'password' => 'required',
            'jenis' => 'required',
            'bagian' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal melakukan UPDATE data Petugas',
                'data' => $validator->errors()
            ]);
        }

        $dataPetugas->username = $request->username;
        $dataPetugas->password = Hash::make($request->password);
        $dataPetugas->jenis = $request->jenis;
        $dataPetugas->bagian = $request->bagian;

        $post = $dataPetugas->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan UPDATE data Petugas'
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
        $dataPetugas = Petugas::find($id);

        if(empty($dataPetugas)){
            return response()->json([
                'status' => false,
                'message' => 'Data Petugas tidak ditemukan'
            ], 404);
        }

        $post = $dataPetugas->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan DELETE data Petugas'
        ]);
    }
}
