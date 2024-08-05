<?php

namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller;
use App\Models\Barang;



class ListProdukController extends Controller
{
    public function index()
    {
        $data = Barang::leftJoin('harga_barang', 'harga_barang.id_barang', '=', 'barang.id')
        ->leftJoin('outlet', 'outlet.id', '=', 'harga_barang.id_jenis_outlet')
        ->select('barang.id', 'barang.nama', 'harga_barang.harga', 'barang.keterangan')
        ->orderByDesc('harga_barang.tanggal')
        ->get();

    if ($data->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'Tidak ada data yang sesuai dengan kriteria',
        ], 404);
    }

    return response()->json([
        'status' => true,
        'message' => 'Data List Ditemukan',
        'data' => $data
    ], 200);
    }
    


}
