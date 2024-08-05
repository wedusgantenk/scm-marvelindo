<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TransaksiDepoImport;
use App\Models\Barang;
use App\Models\Cluster;
use App\Models\Depo;
use App\Models\TransaksiDepo;
use App\Models\TransaksiDepoDetail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiDepoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = TransaksiDepo::with('cluster', 'depo')->get();
        return view('admin.transaksi.distribusi_depo.index', compact('data'));
    }

    public function create()
    {
        $clientCls = new Client();
        $urlCls = "http://scmapi.satriatech.com/api/admin/cluster";
        $responseCls = $clientCls->request('GET', $urlCls);
        $contentCls = $responseCls->getBody()->getContents();
        $contentArrayCls = json_decode($contentCls, true);
        $cluster = $contentArrayCls['data'];

        $clientb = new Client;
        $urlb = "http://scmapi.satriatech.com/api/admin/petugas";
        $responseb = $clientb->request('GET', $urlb);
        $contentb = $responseb->getBody()->getContents();
        $contentArrayb = json_decode($contentb, true);
        $petugas = $contentArrayb['data'];

        $clientc = new Client;
        $urlc = "http://scmapi.satriatech.com/api/admin/depo";
        $responsec = $clientc->request('GET', $urlc);
        $contentc = $responsec->getBody()->getContents();
        $contentArrayc = json_decode($contentc, true);
        $depo = $contentArrayc['data'];

        return view('admin.transaksi.distribusi_depo.create', compact('cluster', 'depo', 'petugas'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'id_petugas' => 'required|numeric',
                'id_cluster' => 'required|numeric',
                'id_depo' => 'required|numeric',
                'tanggal' => 'required'
            ],
            [
                'id_petugas.required' => 'petugas harus dipilih',
                'id_petugas.numeric' => 'petugas harus dipilih',
                'id_cluster.required' => 'cluster harus dipilih',
                'id_cluster.numeric' => 'cluster harus dipilih',
                'id_depo.required' => 'depo harus dipilih',
                'id_depo.numeric' => 'depo harus dipilih',
                'tanggal.required' => 'tanggal harus diisi'
            ]
        );
        $parameter = [
            'tanggal' => $request->tanggal,
            'id_petugas' => $request->id_petugas,
            'id_cluster' => $request->id_cluster,
            'id_depo' => $request->id_depo,
            'status' => 'true',
        ];
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/transaksidepo";
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.transaksi.distribusi_depo')->with('success', 'depo telah ditambahkan');
    }

    public function edit($id)
    {
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/transaksidepo/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];

        $clientb = new Client;
        $urlb = "http://scmapi.satriatech.com/api/admin/petugas";
        $responseb = $clientb->request('GET', $urlb);
        $contentb = $responseb->getBody()->getContents();
        $contentArrayb = json_decode($contentb, true);

        $client = new Client();
        $urlDepo = "http://scmapi.satriatech.com/api/admin/depo";
        $responseDepo = $client->request('GET', $urlDepo);
        $contentDepo = $responseDepo->getBody()->getContents();
        $contentArrayDepo = json_decode($contentDepo, true);

        $clientCls = new Client();
        $urlCls = "http://scmapi.satriatech.com/api/admin/cluster";
        $responseCls = $clientCls->request('GET', $urlCls);
        $contentCls = $responseCls->getBody()->getContents();
        $contentArrayCls = json_decode($contentCls, true);

        if (!isset($contentArray['status']) || $contentArray['status'] !== true) {
            $error = isset($contentArray['message']) ? $contentArray['message'] : "Unknown error occurred";
            return redirect()->route('admin.transaksi.distribusi_depo')->withErrors($error);
        } else {
            $data = $contentArray['data'];
            $petugas = $contentArrayb['data'];
            $cluster = $contentArrayCls['data'];
            $depo = $contentArrayDepo['data'];
            return view('admin.transaksi.distribusi_depo.edit', compact('data', 'cluster', 'depo', 'petugas'));
        }
    }

    public function update(Request $request, $id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/transaksidepo/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        $request->validate([
            'id_petugas' => 'required|numeric',
            'id_cluster' => 'required|numeric',
            'id_depo' => 'required|numeric',
            'tanggal' => 'required'
        ], [
            'id_petugas.required' => 'petugas harus dipilih',
            'id_petugas.numeric' => 'petugas harus dipilih',
            'id_cluster.required' => 'cluster harus dipilih',
            'id_cluster.numeric' => 'cluster harus dipilih',
            'id_depo.required' => 'depo harus dipilih',
            'id_depo.numeric' => 'depo harus dipilih',
            'tanggal.required' => 'tanggal harus diisi'
        ]);

        $dataToUpdate = [
            'tanggal' => $request->tanggal,
            'id_petugas' => $request->id_petugas,
            'id_cluster' => $request->id_cluster,
            'id_depo' => $request->id_depo,
            'status' => 'true',
        ];

        $client->request('PUT', $url, [
            'json' => $dataToUpdate,
        ]);

        return redirect()->route('admin.transaksi.distribusi_depo')->with('success', 'depo telah diubah');
    }

    public function destroy($id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/transaksidepo/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.transaksi.distribusi_depo')->with('success', 'depo telah dihapus');
    }
    // public function detail($id)
    // {
    //     $data = TransaksiDepoDetail::where('id_transaksi', $id)->get();
    //     return view('admin.transaksi.distribusi_depo.detail.index', compact('data'));
    // }

    public function import()
    {
        $cluster = Cluster::all();
        $depo = Depo::all();
        return view('admin.transaksi.distribusi_depo.import', compact('cluster', 'depo'));
    }

    public function import_excel(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // Capture the uploaded file
        $file = $request->file('file');

        // Create a unique file name
        $nama_file = rand() . "_" . $file->getClientOriginalName();

        // Move the file to the 'distribusi_depo' folder within the 'public' directory
        $file->move(public_path('distribusi_depo'), $nama_file);

        // Construct the file path
        $filePath = public_path('distribusi_depo/' . $nama_file);

        // Check if the file exists after moving it
        if (!file_exists($filePath)) {
            return back()->withErrors(['file' => 'File upload failed or file path is incorrect.']);
        }

        // Import data from the uploaded file
        try {
            $data = Excel::toCollection(new TransaksiDepoImport, $filePath);
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Error during Excel import: ' . $e->getMessage()]);
        }

        foreach ($data as $dat) {
            foreach ($dat as $d) {
                $barang = Barang::where('nama', $d['item_name'])->first();

                if ($barang) {
                    $transaksi = TransaksiDepo::firstOrCreate([
                        'id_petugas' => Auth::user()->id,
                        'id_cluster' => $request->cluster_id,
                        'id_depo' => $request->depo_id,
                        'tanggal' => date('Y-m-d'),
                        'status' => '',
                    ]);

                    TransaksiDepoDetail::firstOrCreate([
                        'id_transaksi' => $transaksi->id,
                        'id_barang' => $barang->id,
                        'kode_unik' => $d['iccid'],
                    ]);
                } else {
                    // Log or handle the case where the item does not exist
                    \Log::warning('Barang not found for item name: ' . $d['item_name']);
                }
            }
        }

        // Redirect back with success message
        return redirect()->route('admin.transaksi.distribusi_depo')->with('success', 'Barang masuk telah ditambahkan');
    }
}
