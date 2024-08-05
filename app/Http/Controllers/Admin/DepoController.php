<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Models\Cluster;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DepoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/depo";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.depo.index', ['data' => $data]);
    }

    public function create()
    {
        $clientCls = new Client();
        $urlCls = "http://scmapi.satriatech.com/api/admin/cluster";
        $responseCls = $clientCls->request('GET', $urlCls);
        $contentCls = $responseCls->getBody()->getContents();
        $contentArrayCls = json_decode($contentCls, true);
        $cluster = $contentArrayCls['data'];
        return view('admin.depo.create', compact('cluster'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|unique:depo',
                'cluster_id' => 'required|numeric',
                'alamat' => 'required'
            ],
            [
                'nama.required' => 'Nama depo harus diisi',
                'nama.unique' => 'depo sudah ada',
                'cluster_id.required' => 'cluster harus dipilih',
                'cluster_id.numeric' => 'cluster harus dipilih',
                'alamat.required' => 'alamat harus diisi'
            ]
        );
        $parameter = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'id_cluster' => $request->cluster_id,
        ];
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/depo";
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.depo')->with('success', 'depo telah ditambahkan');
    }

    public function edit($id)
    {
        $client = new Client();
        $urlDepo = "http://scmapi.satriatech.com/api/admin/depo/$id";
        $responseDepo = $client->request('GET', $urlDepo);
        $contentDepo = $responseDepo->getBody()->getContents();
        $contentArrayDepo = json_decode($contentDepo, true);

        $clientCls = new Client();
        $urlCls = "http://scmapi.satriatech.com/api/admin/cluster";
        $responseCls = $clientCls->request('GET', $urlCls);
        $contentCls = $responseCls->getBody()->getContents();
        $contentArrayCls = json_decode($contentCls, true);

        if (!isset($contentArrayDepo['status']) || $contentArrayDepo['status'] !== true) {
            $error = isset($contentArrayDepo['message']) ? $contentArrayDepo['message'] : "Unknown error occurred";
            return redirect()->route('admin.depo')->withErrors($error);
        } else {
            $data = $contentArrayDepo['data'];
            $cluster = $contentArrayCls['data'];
            return view('admin.depo.edit', compact('data', 'cluster'));
        }
    }

    public function update(Request $request, $id)
    {
        $client = new Client();
        $urlDepo = "http://scmapi.satriatech.com/api/admin/depo/$id";
        $responseDepo = $client->request('GET', $urlDepo);
        $contentDepo = $responseDepo->getBody()->getContents();
        $contentArrayDepo = json_decode($contentDepo, true);
        $data = $contentArrayDepo['data'];
        $request->validate([
            'nama' => 'required|unique:depo,nama,' . $id . ',id',
            'cluster_id' => 'required|numeric',
        ], [
            'nama.required' => 'Nama depo harus diisi',
            'nama.unique' => 'Nama depo sudah ada',
            'cluster_id.required' => 'Cluster harus dipilih',
            'cluster_id.numeric' => 'Cluster harus berupa angka',
        ]);

        $dataToUpdate = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'id_cluster' => $request->cluster_id,
        ];

        $client->request('PUT', $urlDepo, [
            'json' => $dataToUpdate,
        ]);

        return redirect()->route('admin.depo')->with('success', 'depo telah diubah');
    }

    public function destroy($id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/depo/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.depo')->with('success', 'depo telah dihapus');
    }
}
