<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailBarang;
use App\Models\Cluster;
use App\Models\Depo;
use App\Models\HistoriBarang;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HistoriBarangController extends Controller
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
            "http://scmapi.satriatech.com/api/admin/historibarang",
            "http://scmapi.satriatech.com/api/admin/detailbarang",
            "http://scmapi.satriatech.com/api/admin/cluster",
            "http://scmapi.satriatech.com/api/admin/depo",
        ];

        $data = fetchData($client, $urlList[0]);
        $detail_barang = collect(fetchData($client, $urlList[1]));
        $cluster = collect(fetchData($client, $urlList[2]));
        $depo = collect(fetchData($client, $urlList[3]));

        // Combine the data
        $combinedData = collect($data)->map(function ($d) use ($detail_barang, $cluster, $depo) {
            $d['detail_barang'] = $detail_barang->firstWhere('id', $d['id_detail_barang']);
            $d['lokasi_asal'] = $cluster->firstWhere('id', $d['id_lokasi_asal']) ?? $depo->firstWhere('id', $d['id_lokasi_asal']);
            $d['lokasi_tujuan'] = $cluster->firstWhere('id', $d['id_lokasi_tujuan']) ?? $depo->firstWhere('id', $d['id_lokasi_tujuan']);
            return $d;
        });

        return view('admin.histori_barang.index', [
            'data' => $combinedData
        ]);
    }

    public function create()
    {
        $clienta = new Client;
        $urla = "http://scmapi.satriatech.com/api/admin/detailbarang";
        $responsea = $clienta->request('GET', $urla);
        $contenta = $responsea->getBody()->getContents();
        $contentArraya = json_decode($contenta, true);
        $detail_barang = $contentArraya['data'];

        $clientb = new Client;
        $urlb = "http://scmapi.satriatech.com/api/admin/cluster";
        $responseb = $clientb->request('GET', $urlb);
        $contentb = $responseb->getBody()->getContents();
        $contentArrayb = json_decode($contentb, true);
        $cluster = $contentArrayb['data'];

        $clientc = new Client;
        $urlc = "http://scmapi.satriatech.com/api/admin/depo";
        $responsec = $clientc->request('GET', $urlc);
        $contentc = $responsec->getBody()->getContents();
        $contentArrayc = json_decode($contentc, true);
        $depo = $contentArrayc['data'];

        return view('admin.histori_barang.create', compact('detail_barang', 'cluster', 'depo'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'id_detail_barang' => 'required|numeric',
                'type' => 'required',
                'id_lokasi_asal' => 'required|numeric',
                'id_lokasi_tujuan' => 'required|numeric',
                'tanggal' => 'required',
            ],
            [
                'id_detail_barang.required' => 'Detail barang harus diisi',
                'type.required' => 'Tipe harus diisi',
                'id_lokasi_asal.required' => 'Lokasi asal barang harus diisi',
                'id_lokasi_tujuan.required' => 'Lokasi tujuan barang harus diisi',
                'tanggal.required' => 'tanggal pengiriman harus diisi',
            ]
        );
        $parameter = [
            'id_detail_barang' => $request->id_detail_barang,
            'type' => $request->type,
            'id_lokasi_asal' => $request->id_lokasi_asal,
            'id_lokasi_tujuan' => $request->id_lokasi_tujuan,
            'tanggal' => $request->tanggal
        ];

        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/historibarang";
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.histori_barang')->with('success', 'histori barang telah ditambahkan');
    }

    public function edit($id)
    {
        $data = HistoriBarang::findorfail($id);
        $detail_barang = DetailBarang::all();
        $cluster = Cluster::all();
        $depo = Depo::all();
        return view('admin.histori_barang.edit', compact('data', 'detail_barang', 'cluster', 'depo'));
    }

    public function update(Request $request, $id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/historibarang/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $request->validate(
            [
                'id_detail_barang' => 'required|numeric',
                'type' => 'required',
                'id_lokasi_asal' => 'required|numeric',
                'id_lokasi_tujuan' => 'required|numeric',
                'tanggal' => 'required',
            ],
            [
                'id_detail_barang.required' => 'Detail barang harus diisi',
                'type.required' => 'Tipe harus diisi',
                'id_lokasi_asal.required' => 'Lokasi asal barang harus diisi',
                'id_lokasi_tujuan.required' => 'Lokasi tujuan barang harus diisi',
                'tanggal.required' => 'tanggal pengiriman harus diisi',
            ]
        );
        $dataToUpdate = [
            'id_detail_barang' => $request->id_detail_barang,
            'type' => $request->type,
            'id_lokasi_asal' => $request->id_lokasi_asal,
            'id_lokasi_tujuan' => $request->id_lokasi_tujuan,
            'tanggal' => $request->tanggal
        ];

        $client->request('PUT', $url, [
            'json' => $dataToUpdate,
        ]);

        return redirect()->route('admin.histori_barang')->with('success', 'histori telah diubah');
    }

    public function destroy($id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/historibarang/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.histori_barang')->with('success', 'histori telah dihapus');
    }
}
