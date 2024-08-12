<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiDepo;
use App\Models\TransaksiDepoDetail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransaksiDepoDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id_transaksi)
    {
         // Ambil data transaksi depo berdasarkan ID yang dikirim
        $data = TransaksiDepoDetail::with('transaksiDepo', 'barang', 'detail')
        ->where('id', $id_transaksi)
        ->firstOrFail();

         // Debug hasil query
        Log::info('Data hasil query:', ['data' => $data]);


        return view('admin.transaksi.distribusi_depo.detail.index', compact('data'));
    }

    

    public function create()
    {
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/transaksidepo";
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

        return view('admin.transaksi.distribusi_depo.detail.create', compact('barang', 'transaksi', 'detail'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'id_barang' => 'required|numeric',
                'id_transaksi' => 'required|numeric|unique:transaksi_distribusi_depo_detail',
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
        TransaksiDepoDetail::create([
            'kode_unik' => $request->kode_unik,
            'id_barang' => $request->id_barang,
            'id_transaksi' => $request->id_transaksi,
            'status' => 'true',
        ]);
        
        return redirect()->route('admin.transaksi.distribusi_depo.detail')->with('success', 'depo telah ditambahkan');
    }

    public function edit($id)
    {
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/transaksidepodetail/$id";
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
        $urld = "http://scmapi.satriatech.com/api/admin/transaksidepo";
        $responsed = $clientd->request('GET', $urld);
        $contentd = $responsed->getBody()->getContents();
        $contentArrayd = json_decode($contentd, true);

        if (!isset($contentArray['status']) || $contentArray['status'] !== true) {
            $error = isset($contentArray['message']) ? $contentArray['message'] : "Unknown error occurred";
            return redirect()->route('admin.transaksi.distribusi_depo')->withErrors($error);
        } else {
            $data = $contentArray['data'];
            $barang = $contentArrayb['data'];
            $transaksi = $contentArrayd['data'];
            $detail = $contentArrayc['data'];
            return view('admin.transaksi.distribusi_depo.detail.edit', [
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
        $url = "http://scmapi.satriatech.com/api/admin/transaksidepodetail/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        $request->validate(
            [
                'id_barang' => 'required|numeric',
                'id_transaksi' => 'required|numeric|unique:transaksi_distribusi_depo_detail',
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

        return redirect()->route('admin.transaksi.distribusi_depo.detail')->with('success', 'depo telah diubah');
    }

    public function destroy($id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/transaksidepodetail/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.transaksi.distribusi_depo.detail')->with('success', 'depo telah dihapus');
    }
}
