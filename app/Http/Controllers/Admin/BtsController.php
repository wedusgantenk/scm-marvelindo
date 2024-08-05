<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bts;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BtsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/bts";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.bts.index', compact('data'));
    }

    public function create()
    {
        return view('admin.bts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:bts',
        ],
        [
            'nama.required' => 'Nama BTS harus diisi',
            'nama.unique' => 'BTS sudah ada',
        ]);
        $parameter = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'lang' => $request->long,
            'lat' => $request->lat,
        ];

        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/bts";
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.bts')->with('success', 'BTS telah ditambahkan');
    }

    public function edit($id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/bts/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if (!isset($contentArray['status']) || $contentArray['status'] !== true) {
            $error = isset($contentArray['message']) ? $contentArray['message'] : "Unknown error occurred";
            return redirect()->route('admin.bts')->withErrors($error);
        } else {
            $data = $contentArray['data'];
            return view('admin.bts.edit', compact('data'));
        }
    }

    public function update(Request $request, $id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/bts/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        $request->validate([
            'nama' => 'required',
        ],
        [
            'nama.required' => 'Nama BTS harus diisi',
        ]);
        if ($data['nama'] != $request['nama']) {
            $request->validate(
                [
                    'nama' => 'unique:bts',
                ],
                [
                    'nama.unique' => 'Nama BTS sudah ada',
                ]
            );
        }
        $dataToUpdate = [
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'lang' => $request->long,
            'lat' => $request->lat,
        ];

        $client->request('PUT', $url, [
            'json' => $dataToUpdate,
        ]);

        return redirect()->route('admin.bts')->with('success', 'BTS telah diubah');
    }

    public function destroy($id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/bts/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.bts')->with('success', 'BTS telah dihapus');
    }
}
