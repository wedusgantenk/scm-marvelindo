<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\DetailBarang;
use App\Models\JenisOutlet;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DetailBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = DetailBarang::with('barang', 'barang_masuk')->get();
        return view('admin.detail_barang.index', compact('data'));
    }

    public function create()
    {
        $data = DetailBarang::all();
        $nama_barang = Barang::all();
        $barang_masuk = BarangMasuk::all();
        return view('admin.detail_barang.create', compact('data', 'barang_masuk', 'nama_barang'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'id_barang' => 'required|numeric',
                'id_barang_masuk' => 'required|numeric',
                'kode_unik' => 'required|numeric',
                'status' => ['in:1,0']
            ],
            // [
            //     'nama.required' => 'Nama barang harus diisi',
            //     'nama.unique' => 'barang sudah ada',
            //     'id_jenis.required' => 'Jenis barang harus dipilih',
            //     'id_jenis.numeric' => 'Jenis barang harus dipilih',
            // ]
        );
        $parameter = [
            'id_barang' => $request->id_barang,
            'id_barang_masuk' => $request->id_barang_masuk,
            'kode_unik' => $request->kode_unik,
            'status' => $request->status,
            // 'fisik' => $request->has('fisik'),
            // 'keterangan' => $request->keterangan,
        ];

        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/detailbarang";
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        return redirect()->route('admin.detail_barang')->with('success', 'barang telah ditambahkan');
    }

    public function edit($id)
    {
        $data = DetailBarang::findorfail($id);
        $nama_barang = Barang::all();
        $barang_masuk = BarangMasuk::all();
        return view('admin.detail_barang.edit', compact('data', 'nama_barang', 'barang_masuk'));
    }

    public function update(Request $request, $id)
    {
        // Initialize Guzzle client
        $client = new Client();

        // URL for retrieving existing data
        $getUrl = "http://scmapi.satriatech.com/api/admin/detailbarang/$id";

        try {
            // Make GET request to retrieve existing data
            $response = $client->get($getUrl);
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);
            $data = $contentArray['data']; // Assuming 'data' is the key containing your existing data
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., API not reachable, data not found)
            return redirect()->back()->with('error', 'Failed to retrieve data from API.');
        }

        // Validate the request data
        $validatedData = $request->validate([
            'id_barang' => 'required|numeric',
            'id_barang_masuk' => 'required|numeric',
            'kode_unik' => 'required|numeric',
            'status' => ['required', Rule::in([1, 0])], // Validate status against allowed values
        ]);

        // Data to update
        $dataToUpdate = [
            'id_barang' => $validatedData['id_barang'],
            'id_barang_masuk' => $validatedData['id_barang_masuk'],
            'kode_unik' => $validatedData['kode_unik'],
            'status' => $validatedData['status'],
        ];

        // URL for updating data
        $putUrl = "http://scmapi.satriatech.com/api/admin/detailbarang/$id";

        try {
            // Make PUT request to update data
            $response = $client->put($putUrl, [
                'json' => $dataToUpdate,
            ]);

            // Check if update was successful (you may want to validate response status code here)

            // Redirect with success message
            return redirect()->route('admin.detail_barang')->with('success', 'Detail barang telah diubah');
        } catch (\Exception $e) {
            // Handle update failure
            return redirect()->back()->with('error', 'Failed to update detail barang.');
        }
    }
    public function destroy($id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/detailbarang/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.detail_barang')->with('success', 'detail barang telah dihapus');
    }
}
