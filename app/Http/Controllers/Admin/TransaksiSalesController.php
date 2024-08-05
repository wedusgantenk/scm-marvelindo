<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TransaksiSalesImport;
use App\Models\Barang;
use App\Models\Depo;
use App\Models\Sales;
use App\Models\TransaksiSales;
use App\Models\TransaksiSalesDetail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiSalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = TransaksiSales::with('depo', 'sales')->get();
        return view('admin.transaksi.distribusi_sales.index', compact('data'));
    }

    public function create()
    {
        $clientc = new Client;
        $urlc = "http://scmapi.satriatech.com/api/admin/depo";
        $responsec = $clientc->request('GET', $urlc);
        $contentc = $responsec->getBody()->getContents();
        $contentArrayc = json_decode($contentc, true);
        $depo = $contentArrayc['data'];

        $clientSls = new Client();
        $urlSls = "http://scmapi.satriatech.com/api/admin/sales";
        $responseSls = $clientSls->request('GET', $urlSls);
        $contentSls = $responseSls->getBody()->getContents();
        $contentArraySls = json_decode($contentSls, true);
        $sales = $contentArraySls['data'];

        $clientb = new Client;
        $urlb = "http://scmapi.satriatech.com/api/admin/petugas";
        $responseb = $clientb->request('GET', $urlb);
        $contentb = $responseb->getBody()->getContents();
        $contentArrayb = json_decode($contentb, true);
        $petugas = $contentArrayb['data'];

        return view('admin.transaksi.distribusi_sales.create', compact('sales', 'depo', 'petugas'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'id_depo' => 'required|numeric',
                'id_sales' => 'required|numeric',
                'id_petugas' => 'required|numeric',
                'tanggal' => 'required'
            ],
            [
                'id_depo.required' => 'depo harus dipilih',
                'id_depo.numeric' => 'depo harus dipilih',
                'id_sales.required' => 'sales harus dipilih',
                'id_sales.numeric' => 'sales harus dipilih',
                'id_petugas.required' => 'petugas harus dipilih',
                'id_petugas.numeric' => 'petugas harus dipilih',
                'tanggal.required' => 'tanggal harus diisi'
            ]
        );
        $parameter = [
            'tanggal' => $request->tanggal,
            'id_depo' => $request->id_depo,
            'id_sales' => $request->id_sales,
            'id_petugas' => $request->id_petugas,
            'status' => 'true',
        ];
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/transaksisales";
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.transaksi.distribusi_sales')->with('success', 'depo telah ditambahkan');
    }

    public function edit($id)
    {
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/transaksisales/$id";
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

        $clientSls = new Client();
        $urlSls = "http://scmapi.satriatech.com/api/admin/sales";
        $responseSls = $clientSls->request('GET', $urlSls);
        $contentSls = $responseSls->getBody()->getContents();
        $contentArraySls = json_decode($contentSls, true);

        if (!isset($contentArrayDepo['status']) || $contentArrayDepo['status'] !== true) {
            $error = isset($contentArrayDepo['message']) ? $contentArrayDepo['message'] : "Unknown error occurred";
            return redirect()->route('admin.transaksi.distribusi_sales')->withErrors($error);
        } else {
            $data = $contentArray['data'];
            $depo = $contentArrayDepo['data'];
            $sales = $contentArraySls['data'];
            $petugas = $contentArrayb['data'];
            return view('admin.transaksi.distribusi_sales.edit', compact('data', 'sales', 'depo', 'petugas'));
        }
    }

    public function update(Request $request, $id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/transaksisales/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        $request->validate([
            'id_petugas' => 'required|numeric',
            'id_sales' => 'required|numeric',
            'id_depo' => 'required|numeric',
            'tanggal' => 'required'
        ], [
            'id_petugas.required' => 'petugas harus dipilih',
            'id_petugas.numeric' => 'petugas harus dipilih',
            'id_sales.required' => 'sales harus dipilih',
            'id_sales.numeric' => 'sales harus dipilih',
            'id_depo.required' => 'depo harus dipilih',
            'id_depo.numeric' => 'depo harus dipilih',
            'tanggal.required' => 'tanggal harus diisi'
        ]);

        $dataToUpdate = [
            'tanggal' => $request->tanggal,
            'id_petugas' => $request->id_petugas,
            'id_sales' => $request->id_sales,
            'id_depo' => $request->id_depo,
            'status' => 'true',
        ];

        $client->request('PUT', $url, [
            'json' => $dataToUpdate,
        ]);

        return redirect()->route('admin.transaksi.distribusi_sales')->with('success', 'depo telah diubah');
    }

    public function destroy($id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/transaksisales/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.transaksi.distribusi_sales')->with('success', 'depo telah dihapus');
    }
    public function detail($id)
    {
        $data = TransaksiSalesDetail::where('id_transaksi', $id)->get();
        return view('admin.transaksi.distribusi_sales.detail', compact('data'));
    }

    public function import()
    {
        $depo = Depo::all();
        $sales = Sales::all();
        return view('admin.transaksi.distribusi_sales.import', compact('depo', 'sales'));
    }

    public function import_excel(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // Capture the uploaded file
        $file = $request->file('file');

        // Create a unique file name
        $nama_file = rand() . "_" . $file->getClientOriginalName();

        // Move the file to the 'distribusi_sales' folder within the 'public' directory
        $file->move(public_path('distribusi_sales'), $nama_file);

        // Construct the file path
        $filePath = public_path('distribusi_sales/' . $nama_file);

        // Check if the file exists after moving it
        if (!file_exists($filePath)) {
            return back()->withErrors(['file' => 'File upload failed or file path is incorrect.']);
        }

        // Import data from the uploaded file
        try {
            $data = Excel::toCollection(new TransaksiSalesImport, $filePath);
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Error during Excel import: ' . $e->getMessage()]);
        }

        foreach ($data as $sheet) {
            foreach ($sheet as $row) {
                $barang = Barang::where('nama', $row['item_name'])->first();

                if ($barang) {
                    $id_depo = $request->depo_id;
                    $kode_unik = $row['iccid'];

                    $barang_depo_exists = TransaksiSales::whereHas('details', function ($query) use ($kode_unik) {
                        $query->where('kode_unik', $kode_unik);
                    })->where('id_depo', $id_depo)->exists();

                    if (!$barang_depo_exists) {
                        $transaksi = TransaksiSales::firstOrCreate([
                            'id_petugas' => Auth::user()->id,
                            'id_sales' => $request->sales_id,
                            'id_depo' => $request->depo_id,
                            'tanggal' => date('Y-m-d'),
                            'status' => '',
                        ]);

                        TransaksiSalesDetail::firstOrCreate([
                            'id_transaksi' => $transaksi->id,
                            'id_barang' => $barang->id,
                            'kode_unik' => $row['iccid'],
                        ]);
                    } else {
                        \Log::warning('Barang already exists in the selected depo for kode_unik: ' . $kode_unik);
                    }
                } else {
                    \Log::warning('Barang not found for item name: ' . $row['item_name']);
                }
            }
        }

        // Redirect back with success message
        return redirect()->route('admin.transaksi.distribusi_sales')->with('success', 'Barang masuk telah ditambahkan');
    }
}
