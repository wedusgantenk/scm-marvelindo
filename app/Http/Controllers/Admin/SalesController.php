<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use App\Models\Sales;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SalesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/sales";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.sales.index', ['data' => $data]);
    }

    public function create()
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/depo";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $depo = $contentArray['data'];
        return view('admin.sales.create', compact('depo'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required',
                'email' => 'required',
                'id_depo' => 'required',
                'area' => 'required',
                'password' => 'required',
                'status' => 'required',
            ], [
                'nama.required' => 'harus diisi!',
                'email.required' => 'harus diisi!',
                'id_depo.required' => 'harus diisi!',
                'area.required' => 'harus diisi!',
                'password.required' => 'harus diisi!',
                'status.required' => 'harus diisi!',
            ]
        );

        Sales::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'id_depo' => $request->id_depo,
            'area' => $request->area,
            'password' => $request->password,
            'status' => $request->status,

        ]);

        return redirect()->route('admin.sales')->with('success', 'User ' . $request->name . ' telah ditambahkan');
    }

    public function edit($id)
    {
        $client = new Client();
        $urlSales = "http://scmapi.satriatech.com/api/admin/sales/$id";
        $responseSales = $client->request('GET', $urlSales);
        $contentSales = $responseSales->getBody()->getContents();
        $contentArraySales = json_decode($contentSales, true);

        $clientDepo = new Client();
        $urlDepo = "http://scmapi.satriatech.com/api/admin/depo";
        $responseDepo = $clientDepo->request('GET', $urlDepo);
        $contentDepo = $responseDepo->getBody()->getContents();
        $contentArrayDepo = json_decode($contentDepo, true);

        if (!isset($contentArraySales['status']) || $contentArraySales['status'] !== true) {
            $error = isset($contentArraySales['message']) ? $contentArraySales['message'] : "Unknown error occurred";
            return redirect()->route('admin.depo')->withErrors($error);
        } else {
            $data = $contentArraySales['data'];
            $depo = $contentArrayDepo['data'];
            return view('admin.sales.edit', compact('data', 'depo'));
        }
    }

    public function update(Request $request, $id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/sales/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        $request->validate([
            'nama' => ['required'],
            'email' => ['required'],
            'area' => ['required'],
            'password' => ['required'],
            'status' => ['required'],
            'id_depo' => ['required'],
        ]);
        $dataToUpdate = [
            'nama' => $request->nama,
            'email' => $request->email,
            'area' => $request->area,
            'password' => $request->password,
            'status' => $request->status,
            'id_depo' => $request->id_depo,
        ];
        $client->request('PUT', $url, [
            'json' => $dataToUpdate,
        ]);
        return redirect()->route('admin.sales')->with('success', 'sales telah diubah');
    }

    public function destroy($id)
    {

        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/sales/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.sales')->with('success', 'User telah dihapus');
    }
}
