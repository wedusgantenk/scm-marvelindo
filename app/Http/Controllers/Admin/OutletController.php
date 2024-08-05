<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bts;
use App\Models\Outlet;
use App\Models\JenisOutlet;
use App\Models\Depo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/outlet";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.outlet.index', ['data' => $data]);
    }

    public function create()
    {
        $clienta = new Client;
        $urla = "http://scmapi.satriatech.com/api/admin/bts";
        $responsea = $clienta->request('GET', $urla);
        $contenta = $responsea->getBody()->getContents();
        $contentArraya = json_decode($contenta, true);
        $bts = $contentArraya['data'];

        $clientb = new Client;
        $urlb = "http://scmapi.satriatech.com/api/admin/jenisoutlet";
        $responseb = $clientb->request('GET', $urlb);
        $contentb = $responseb->getBody()->getContents();
        $contentArrayb = json_decode($contentb, true);
        $jenis_outlet = $contentArrayb['data'];

        $clientc = new Client;
        $urlc = "http://scmapi.satriatech.com/api/admin/depo";
        $responsec = $clientc->request('GET', $urlc);
        $contentc = $responsec->getBody()->getContents();
        $contentArrayc = json_decode($contentc, true);
        $depo = $contentArrayc['data'];

        return view('admin.outlet.create', compact('bts', 'jenis_outlet', 'depo'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|unique:outlet',
                'bts_id' => 'required|numeric',
                'jenis_id' => 'required|numeric',
                'depo_id' => 'required|numeric',
            ],
            [
                'nama.required' => 'Nama outlet harus diisi',
                'nama.unique' => 'outlet sudah ada',
                'bts_id.required' => 'bts harus dipilih',
                'bts_id.numeric' => 'bts harus dipilih',
                'jenis_id.required' => 'jenis harus dipilih',
                'jenis_id.numeric' => 'jenis harus dipilih',
                'depo_id.required' => 'depo harus dipilih',
                'depo_id.numeric' => 'depo harus dipilih',
            ]
        );
        $parameter = [
            'nama' => $request->nama,
            'id_bts' => $request->bts_id,
            'id_jenis' => $request->jenis_id,
            'id_depo' => $request->depo_id,
        ];

        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/outlet";
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.outlet')->with('success', 'outlet telah ditambahkan');
    }

    public function edit($id)
    {
        $client = new Client();
        $urls = [
            "outlet" => "http://scmapi.satriatech.com/api/admin/outlet/$id",
            "bts" => "http://scmapi.satriatech.com/api/admin/bts",
            "jenisoutlet" => "http://scmapi.satriatech.com/api/admin/jenisoutlet",
            "depo" => "http://scmapi.satriatech.com/api/admin/depo"
        ];

        $responses = [];
        foreach ($urls as $key => $url) {
            $response = $client->request('GET', $url);
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);
            if (!isset($contentArray['status']) || $contentArray['status'] !== true) {
                $error = isset($contentArray['message']) ? $contentArray['message'] : "Unknown error occurred";
                return redirect()->route('admin.outlet')->withErrors($error);
            }
            $responses[$key] = $contentArray['data'];
        }

        return view('admin.outlet.edit', [
            'data' => $responses['outlet'],
            'bts' => $responses['bts'],
            'jenis_outlet' => $responses['jenisoutlet'],
            'depo' => $responses['depo']
        ]);
    }

    public function update(Request $request, $id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/outlet/$id";

        // Validasi input dari form
        $request->validate([
            'nama' => 'required|unique:outlet,nama,' . $id,
            'id_bts' => 'required|numeric',
            'id_jenis' => 'required|numeric',
            'id_depo' => 'required|numeric',
        ], [
            'nama.required' => 'Nama outlet harus diisi',
            'id_bts.required' => 'BTS harus dipilih',
            'id_bts.numeric' => 'BTS harus berupa angka',
            'id_jenis.required' => 'Jenis harus dipilih',
            'id_jenis.numeric' => 'Jenis harus berupa angka',
            'id_depo.required' => 'Depo harus dipilih',
            'id_depo.numeric' => 'Depo harus berupa angka',
            'nama.unique' => 'Nama outlet sudah ada'
        ]);

        // Data yang akan diupdate
        $dataToUpdate = [
            'nama' => $request->nama,
            'id_bts' => $request->id_bts,
            'id_jenis' => $request->id_jenis,
            'id_depo' => $request->id_depo,
        ];

        // Mengirim permintaan PUT menggunakan Guzzle HTTP Client
        $response = $client->request('PUT', $url, [
            'json' => $dataToUpdate,
        ]);

        // Mengembalikan respons redirect jika berhasil
        return redirect()->route('admin.outlet')->with('success', 'Outlet telah diubah');
    }
    public function destroy($id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/outlet/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.outlet')->with('success', 'outlet telah dihapus');
    }
}
