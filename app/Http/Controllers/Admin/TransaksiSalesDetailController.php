<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiSalesDetail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiSalesDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $client = new Client;

        // Fungsi untuk mengirim permintaan HTTP GET dan mengembalikan hasilnya sebagai array
        function fetchData($client, $url)
        {
            try {
                $response = $client->request('GET', $url);
                $content = $response->getBody()->getContents();
                return json_decode($content, true)['data'];
            } catch (\Exception $e) {
                // Log kesalahan atau tangani sesuai kebutuhan
                return [];
            }
        }

        $urlList = [
            "http://scmapi.satriatech.com/api/admin/transaksisalesdetail",
            "http://scmapi.satriatech.com/api/admin/barang",
            "http://scmapi.satriatech.com/api/admin/detailbarang",
            "http://scmapi.satriatech.com/api/admin/transaksisales",
        ];

        $data = fetchData($client, $urlList[0]);
        $barang = fetchData($client, $urlList[1]);
        $detail = fetchData($client, $urlList[2]);
        $transaksi = fetchData($client, $urlList[3]);

        return view('admin.transaksi.distribusi_sales.detail.index', [
            'data' => $data,
            'barang' => $barang,
            'transaksi' => $transaksi,
            'detail' => $detail
        ]);
    }

    public function create()
    {
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/transaksisales";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $transaksi = $contentArray['data'];

        $clienta = new Client;
        $urla = "http://scmapi.satriatech.com/api/admin/barang";
        $responsea = $clienta->request('GET', $urla);
        $contenta = $responsea->getBody()->getContents();
        $contentArraya = json_decode($contenta, true);
        $barang = $contentArraya['data'];

        $clientb = new Client;
        $urlb = "http://scmapi.satriatech.com/api/admin/detailbarang";
        $responseb = $clientb->request('GET', $urlb);
        $contentb = $responseb->getBody()->getContents();
        $contentArrayb = json_decode($contentb, true);
        $detail = $contentArrayb['data'];

        return view('admin.transaksi.distribusi_sales.detail.create', compact('barang', 'transaksi', 'detail'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'id_barang' => 'required|numeric',
                'id_transaksi' => 'required|numeric|unique:transaksi_distribusi_sales_detail',
                'kode_unik' => 'required'
        ]);
            
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
    
        $data = new TransaksiSalesDetail();
        
        $data->id_barang = $request->id_barang;
        $data->id_transaksi = $request->id_transaksi;
        $data->kode_unik = $request->kode_unik;
    
        $data->save();
    
        return redirect()->route('admin.transaksi_distribusi_sales')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/transaksisalesdetail/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];

        $clientb = new Client;
        $urlb = "http://scmapi.satriatech.com/api/admin/barang";
        $responseb = $clientb->request('GET', $urlb);
        $contentb = $responseb->getBody()->getContents();
        $contentArrayb = json_decode($contentb, true);

        $clientc = new Client();
        $urlc = "http://scmapi.satriatech.com/api/admin/detailbarang";
        $responsec = $clientc->request('GET', $urlc);
        $contentc = $responsec->getBody()->getContents();
        $contentArrayc = json_decode($contentc, true);

        $clientd = new Client();
        $urld = "http://scmapi.satriatech.com/api/admin/transaksisales";
        $responsed = $clientd->request('GET', $urld);
        $contentd = $responsed->getBody()->getContents();
        $contentArrayd = json_decode($contentd, true);

        if (!isset($contentArray['status']) || $contentArray['status'] !== true) {
            $error = isset($contentArray['message']) ? $contentArray['message'] : "Unknown error occurred";
            return redirect()->route('admin.transaksi.distribusi_sales')->withErrors($error);
        } else {
            $data = $contentArray['data'];
            $barang = $contentArrayb['data'];
            $transaksi = $contentArrayd['data'];
            $detail = $contentArrayc['data'];
            return view('admin.transaksi.distribusi_sales.detail.edit', [
                'data' => $data,
                'barang' => $barang,
                'transaksi' => $transaksi,
                'detail' => $detail
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/transaksisalesdetail/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        $request->validate(
            [
                'id_barang' => 'required|numeric',
                'id_transaksi' => 'required|numeric|unique:transaksi_distribusi_sales_detail',
                'kode_unik' => 'required'
            ],
            [
                'id_barang.required' => 'barang harus dipilih',
                'id_barang.numeric' => 'barang harus dipilih',
                'id_transaksi.required' => 'id transaksi harus dipilih',
                'id_transaksi.numeric' => 'id transaksi harus dipilih',
                'id_transaksi.unique' => 'id transaksi tidak boleh sama',
                'kode_unik.required' => 'kode unik harus diisi'
            ]
        );

        $dataToUpdate = [
            'kode_unik' => $request->kode_unik,
            'id_barang' => $request->id_barang,
            'id_transaksi' => $request->id_transaksi,
            'status' => 'true',
        ];

        $client->request('PUT', $url, [
            'json' => $dataToUpdate,
        ]);

        return redirect()->route('admin.transaksi.distribusi_sales.detail')->with('success', 'sales telah diubah');
    }

    public function destroy($id)
    {
       // Temukan data yang akan dihapus
    $data = TransaksiSalesDetail::findOrFail($id);

    // Hapus data
    $data->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.transaksi_distribusi_sales')->with('success', 'Data berhasil dihapus');
    }
}
