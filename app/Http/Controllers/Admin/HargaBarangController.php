<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\HargaBarang;
use App\Models\JenisOutlet;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HargaBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.harga_barang.index');
    }

    // Mengambil data untuk tabel
    public function fetchData()
    {
        $barang = Barang::with(['hargaBarang.jenisOutlet'])->get();
        $jenis_outlets = JenisOutlet::all();

        $columns = [
            [
                'title' => 'Room Name',
                'field' => 'room_name',
                'class' => 'col-md-2 center',
                'editable' => false, // Membuat kolom Room Name tidak dapat diedit
            ],
        ];

        foreach ($jenis_outlets as $index => $outlet) {
            $columns[] = [
                'title' => $outlet->nama,
                'field' => 'price_' . ($index + 1),  // Sesuaikan index field
                'class' => 'col-md-1 center',
                'formatter' => 'formatMoney',
                'editable' => true,
            ];
        }

        $data = $barang->map(function($item) use ($jenis_outlets) {
            $row = [
                'room_name' => $item->nama,
            ];

            foreach ($jenis_outlets as $index => $outlet) {
                $harga = $item->hargaBarang->firstWhere('id_jenis_outlet', $outlet->id);
                $row['price_' . ($index + 1)] = $harga ? $harga->harga : 0;
            }

            return $row;
        });

        return response()->json([
            'columns' => $columns,
            'data' => $data,
        ]);
    }

    // Mengupdate data harga
    public function update(Request $request)
    {
        $data = $request->validate([
            'room_name' => 'required|exists:barang,nama',
            'prices' => 'required|array',
            'prices.*' => 'numeric|min:0',
        ]);

        $barang = Barang::where('nama', $data['room_name'])->firstOrFail();

        foreach ($data['prices'] as $outletName => $harga) {
            $id_jenis_outlet = JenisOutlet::where('nama', $outletName)->firstOrFail()->id;

            $barang->hargaBarang()->updateOrCreate(
                ['id_jenis_outlet' => $id_jenis_outlet],
                ['harga' => $harga]
            );
        }

        return response()->json(['status' => 'success']);
    }

    // public function index()
    // {

    //     $barang = Barang::all();
    //     $jenisoutlet = JenisOutlet::all();
    //     $data = HargaBarang::all();
    //     return view('admin.harga_barang.index', compact('data', 'barang', 'jenisoutlet'));

    // }

    // public function create()
    // {
    //     $clienta = new Client;
    //     $urla = "http://scmapi.satriatech.com/api/admin/barang";
    //     $responsea = $clienta->request('GET', $urla);
    //     $contenta = $responsea->getBody()->getContents();
    //     $contentArraya = json_decode($contenta, true);
    //     $barang = $contentArraya['data'];

    //     $clientb = new Client;
    //     $urlb = "http://scmapi.satriatech.com/api/admin/jenisoutlet";
    //     $responseb = $clientb->request('GET', $urlb);
    //     $contentb = $responseb->getBody()->getContents();
    //     $contentArrayb = json_decode($contentb, true);
    //     $jenis_outlet = $contentArrayb['data'];

    //     return view('admin.harga_barang.create', compact('jenis_outlet','barang'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate(
    //         [
    //             'id_barang' => 'required|numeric',
    //             'tanggal' => 'required',
    //             'id_jenis_outlet' => 'required|numeric',
    //             'harga' => 'required|numeric',
    //         ],
    //         [
    //             'harga.required' => 'harga harus dipilih',
    //             'harga.numeric' => 'harga harus dipilih',
    //             'barang_id.required' => 'Barang harus dipilih',
    //             'barang_id.numeric' => 'Barang harus dipilih',
    //             'tanggal.required' => 'Tanggal harus dipilih',
    //             'jenis_outlet_id.required' => 'Jenis Outlet harus dipilih',
    //             'jenis_outlet_id.numeric' => 'Jenis Outlet harus dipilih',
    //         ]
    //     );
    //     $parameter = [
    //         'id_barang' => $request->id_barang,
    //         'tanggal' => $request->tanggal,
    //         'id_jenis_outlet' => $request->id_jenis_outlet,
    //         'harga' => $request->harga,
    //     ];

    //     $client = new Client;
    //     $url = "http://scmapi.satriatech.com/api/admin/hargabarang";
    //     $response = $client->request('POST', $url, [
    //         'headers' => [
    //             'Content-type' => 'application/json'
    //         ],
    //         'body' => json_encode($parameter)
    //     ]);
    //     $content = $response->getBody()->getContents();
    //     $contentArray = json_decode($content, true);
    //     return redirect()->route('admin.harga_barang')->with('success', 'harga barang telah ditambahkan');
    // }

    // public function edit($id)
    // {
    //     $client = new Client;
    //     $url = "http://scmapi.satriatech.com/api/admin/hargabarang/$id";
    //     $response = $client->request('GET', $url);
    //     $content = $response->getBody()->getContents();
    //     $contentArray = json_decode($content, true);
    //     $data = $contentArray['data'];

    //     $clienta = new Client;
    //     $urla = "http://scmapi.satriatech.com/api/admin/barang";
    //     $responsea = $clienta->request('GET', $urla);
    //     $contenta = $responsea->getBody()->getContents();
    //     $contentArraya = json_decode($contenta, true);
    //     $barang = $contentArraya['data'];

    //     $clientb = new Client;
    //     $urlb = "http://scmapi.satriatech.com/api/admin/jenisoutlet";
    //     $responseb = $clientb->request('GET', $urlb);
    //     $contentb = $responseb->getBody()->getContents();
    //     $contentArrayb = json_decode($contentb, true);
    //     $jenis_outlet = $contentArrayb['data'];if (!isset($contentArray['status']) || $contentArray['status'] !== true) {
    //         $error = isset($contentArray['message']) ? $contentArray['message'] : "Unknown error occurred";
    //         return redirect()->route('admin.harga_barang')->withErrors($error);
    //     } else {
    //         $data = $contentArray['data'];
    //         $barang = $contentArraya['data'];
    //         $jenis_outlet = $contentArrayb['data'];
    //         return view('admin.harga_barang.edit', compact('data', 'barang', 'jenis_outlet'));
    //     }
    // }

    // public function update(Request $request, $id)
    // {
    //     $client = new Client();
    //     $url = "http://scmapi.satriatech.com/api/admin/hargabarang/$id";
    //     $response = $client->request('GET', $url);
    //     $content = $response->getBody()->getContents();
    //     $contentArray = json_decode($content, true);
    //     $data = $contentArray['data'];
    //     $request->validate(
    //         [
    //             'id_barang' => 'required|numeric',
    //             'tanggal' => 'required',
    //             'id_jenis_outlet' => 'required|numeric',
    //             'harga' => 'required|numeric|min:0',
    //         ],
    //         [
    //             'harga.required' => 'harga harus dipilih',
    //             'harga.numeric' => 'harga harus dipilih',
    //             'harga.min:0' => 'harga harus bernilai positif',
    //             'barang_id.required' => 'Barang harus dipilih',
    //             'barang_id.numeric' => 'Barang harus dipilih',
    //             'tanggal.required' => 'Tanggal harus dipilih',
    //             'jenis_outlet_id.required' => 'Jenis Outlet harus dipilih',
    //             'jenis_outlet_id.numeric' => 'Jenis Outlet harus dipilih',
    //         ]
    //     );
    //     $dataToUpdate = [
    //         'id_barang' => $request->id_barang,
    //         'tanggal' => $request->tanggal,
    //         'id_jenis_outlet' => $request->id_jenis_outlet,
    //         'harga' => $request->harga,
    //     ];

    //     $client->request('PUT', $url, [
    //         'json' => $dataToUpdate,
    //     ]);

    //     return redirect()->route('admin.harga_barang')->with('success', 'harga barang telah diubah');
    // }

    // public function destroy($id)
    // {
    //     $client = new Client();
    //     $url = "http://scmapi.satriatech.com/api/admin/hargabarang/$id";
    //     $response = $client->request('DELETE', $url);
    //     $content = $response->getBody()->getContents();
    //     $contentArray = json_decode($content, true);
    //     return redirect()->route('admin.harga_barang')->with('success', 'harga barang telah dihapus');

    // }
    // //
}
