<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\BarangMasukImport;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\DetailBarang;
use App\Models\JenisBarang;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Barang::all();
        return view('admin.barang.index', ['data' => $data]);
    }

        // public function create()
    // {
    //     $clientb = new Client;
    //     $urlb = "http://scmapi.satriatech.com/api/admin/jenisbarang";
    //     $responseb = $clientb->request('GET', $urlb);
    //     $contentb = $responseb->getBody()->getContents();
    //     $contentArrayb = json_decode($contentb, true);
    //     $jenis_barang = $contentArrayb['data'];
    //     return view('admin.barang.create', compact('jenis_barang'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required|unique:barang',
    //         'id_jenis' => 'required|numeric',
    //         'fisik' => ['in:1,0'],
    //     ], [
    //         'nama.required' => 'Nama barang harus diisi',
    //         'nama.unique' => 'Barang sudah ada',
    //         'id_jenis.required' => 'Jenis barang harus dipilih',
    //         'id_jenis.numeric' => 'Jenis barang harus berupa angka',
    //     ]);

    //     // Simpan file gambar ke server lokal (jika ada)
    //     $filename = null;
    //     if ($request->hasFile('gambar')) {
    //         $file = $request->file('gambar');
    //         $filename = time() . '_' . $file->getClientOriginalName();
    //         $file->move('images/barang', $filename);
    //     }

    //     // Persiapkan data yang akan dikirim melalui API
    //     Barang::create([
    //         'nama' => $request->nama,
    //         'id_jenis' => $request->id_jenis,
    //         'gambar' => $filename, // simpan nama file gambar atau null
    //         'fisik' => $request->has('fisik') ? $request->fisik : 0,
    //         'keterangan' => $request->keterangan,
    //     ]);
    //     return redirect()->route('admin.barang')->with('success', 'Barang telah ditambahkan');
    // }

    // public function edit($id)
    // {
    //     $client = new Client;
    //     $url = "http://scmapi.satriatech.com/api/admin/barang/$id";
    //     $response = $client->request('GET', $url);
    //     $content = $response->getBody()->getContents();
    //     $contentArray = json_decode($content, true);
    //     $data = $contentArray['data'];

    //     $clientb = new Client;
    //     $urlb = "http://scmapi.satriatech.com/api/admin/jenisbarang";
    //     $responseb = $clientb->request('GET', $urlb);
    //     $contentb = $responseb->getBody()->getContents();
    //     $contentArrayb = json_decode($contentb, true);

    //     if (!isset($contentArray['status']) || $contentArray['status'] !== true) {
    //         $error = isset($contentArray['message']) ? $contentArray['message'] : "Unknown error occurred";
    //         return redirect()->route('admin.barang')->withErrors($error);
    //     } else {
    //         $data = $contentArray['data'];
    //         $jenis_barang = $contentArrayb['data'];
    //         return view('admin.barang.edit', compact('data', 'jenis_barang'));
    //     }
    // }

    // public function update(Request $request, $id)
    // {
    //     $client = new Client;
    //     $url = "http://scmapi.satriatech.com/api/admin/barang/$id";
    //     $response = $client->request('GET', $url);
    //     $content = $response->getBody()->getContents();
    //     $contentArray = json_decode($content, true);
    //     $data = $contentArray['data'];
    //     $request->validate(
    //         [
    //             'nama' => 'required',
    //             'id_jenis' => 'required|numeric',
    //             'fisik' => ['in:1,0']
    //         ],
    //         [
    //             'nama.required' => 'Nama barang harus diisi',
    //             'id_jenis.required' => 'Jenis barang harus dipilih',
    //             'id_jenis.numeric' => 'Jenis barang harus dipilih',
    //         ]
    //     );
    //     if ($data['nama'] != $request['nama']) {
    //         $request->validate(
    //             [
    //                 'nama' => 'unique:barang',
    //             ],
    //             [
    //                 'nama.unique' => 'nama barang sudah ada',
    //             ]
    //         );
    //     }
    //     $dataToUpdate = [
    //         'nama' => $request->nama,
    //         'id_jenis' => $request->id_jenis,
    //         'gambar' => $request->gambar,
    //         'fisik' => $request->has('fisik') ? $request->fisik : 0,
    //         'keterangan' => $request->keterangan,
    //     ];

    //     $client->request('PUT', $url, [
    //         'json' => $dataToUpdate,
    //     ]);

    //     return redirect()->route('admin.barang')->with('success', 'barang telah diubah');
    // }

    // public function destroy($id)
    // {
    //     $client = new Client();
    //     $url = "http://scmapi.satriatech.com/api/admin/barang/$id";
    //     $response = $client->request('DELETE', $url);
    //     $content = $response->getBody()->getContents();
    //     $contentArray = json_decode($content, true);
    //     return redirect()->route('admin.barang')->with('success', 'barang telah dihapus');
    // }

    // public function import()
    // {
    //     return view('admin.barang.import');
    // }

    // public function import_excel(Request $request)
    // {
    //     // Validasi file
    //     $request->validate([
    //         'file' => 'required|mimes:csv,xls,xlsx'
    //     ]);

    //     // Menangkap file excel
    //     $file = $request->file('file');

    //     // Membuat nama file unik
    //     $nama_file = uniqid() . '_' . $file->getClientOriginalName();

    //     // Upload ke folder file_barang di dalam folder public
    //     $file->move(public_path('file_barang'), $nama_file);

    //     // Import data
    //     Excel::import(new BarangImport, public_path('file_barang/' . $nama_file));

    //     // Alihkan halaman kembali
    //     return redirect()->route('admin.barang')->with('success', 'Barang telah ditambahkan');
    // }


    // public function export()
    // {
    //     $file = time() . 'data-barang.xlsx';
    //     return (new FastExcel(Barang::all()))->download($file, function ($barang) {
    //         return [
    //             'nama' => $barang->nama,
    //             'alamat' => $barang->alamat,
    //             'id_jenis' => $barang->id_jenis,
    //             'fisik' => $barang->fisik,
    //             'keterangan' => $barang->keterangan,

    //         ];
    //     });

    // }
}
