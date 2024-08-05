<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisBarang;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/jenisbarang";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.jenis_barang.index', ['data' => $data]);
    }

    public function create()
    {
        return view('admin.jenis_barang.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|unique:jenis_barang',
            ],
            [
                'nama.required' => 'Nama jenis barang harus diisi',
                'nama.unique' => 'Jenis barang sudah ada',
            ]
        );
        $parameter = [
            'nama' => $request['nama'],
        ];
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/jenisbarang";
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.jenis_barang')->with('success', 'Jenis barang telah ditambahkan');
    }

    public function edit($id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/jenisbarang/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if (!isset($contentArray['status']) || $contentArray['status'] !== true) {
            $error = isset($contentArray['message']) ? $contentArray['message'] : "Unknown error occurred";
            return redirect()->route('admin.jenis_barang')->withErrors($error);
        } else {
            $data = $contentArray['data'];
            return view('admin.jenis_barang.edit', compact('data'));
        }
    }

    public function update(Request $request, $id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/jenisbarang/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        $request->validate(
            [
                'nama' => 'required',
            ],
            [
                'nama.required' => 'Nama jenis barang harus diisi',
            ]
        );
        if ($data['nama'] != $request['nama']) {
            $request->validate(
                [
                    'nama' => 'unique:jenis_barang',
                ],
                [
                    'nama.unique' => 'Jenis barang sudah ada',
                ]
            );
        }
        $dataToUpdate = [
            'nama' => $request->nama,
        ];

        $client->request('PUT', $url, [
            'json' => $dataToUpdate,
        ]);

        return redirect()->route('admin.jenis_barang')->with('success', 'Jenis barang telah diubah');
    }

    public function destroy($id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/jenisbarang/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.jenis_barang')->with('success', 'Jenis barang telah dihapus');
    }
}
