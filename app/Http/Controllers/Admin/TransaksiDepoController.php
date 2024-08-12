<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TransaksiDepoImport;
use App\Models\Barang;
use App\Models\Cluster;
use App\Models\Depo;
use App\Models\TransaksiDepo;
use App\Models\TransaksiDepoDetail;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiDepoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transaksiDistribusiDepos  = TransaksiDepo::with(['cluster', 'depo', 'petugas'])->get()->map(function ($item) {
            // Mengubah format tanggal ke format yang diperlukan untuk input date HTML
            $item->formatted_tanggal = Carbon::parse($item->tanggal)->format('Y-m-d');
            return $item;
        });
        return view('admin.transaksi.distribusi_depo.index', compact('transaksiDistribusiDepos'));
    }


    public function show($id)
    {
        $transaksiDistribusiDepo = TransaksiDepo::with(['details.barang', 'petugas'])->findOrFail($id);
        return view('admin.transaksi.distribusi_depo.detail.index', compact('transaksiDistribusiDepo'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_petugas' => 'required|int|exists:petugas,id',
            'id_cluster' => 'required|int|exists:cluster,id',
            'id_depo' => 'required|int|exists:depo,id',
            'tanggal' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

          // Jika validasi gagal
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }


    $data = new TransaksiDepo();
    
    $data->id_petugas = $request->id_petugas;
    $data->id_cluster = $request->id_cluster;
    $data->id_depo = $request->id_depo;
    $data->tanggal = $request->tanggal;
    $data->status = $request->status;

    $data->save();

    return redirect()->route('admin.transaksi_distribusi_depo')->with('success', 'Data berhasil ditambahkan');

}

    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
{
    // Validasi data menggunakan Validator
    $validator = Validator::make($request->all(), [
        'id_petugas' => 'required|int|exists:petugas,id',
        'id_cluster' => 'required|int|exists:cluster,id',
        'id_depo' => 'required|int|exists:depo,id',
        'tanggal' => 'required|date',
        'status' => 'required|string|max:255',
    ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Temukan data yang akan diupdate
    $data = TransaksiDepo::findOrFail($id);
    
    // Update data
    $data->id_petugas = $request->id_petugas;
    $data->id_cluster = $request->id_cluster;
    $data->id_depo = $request->id_depo;
    $data->tanggal = $request->tanggal;
    $data->status = $request->status;
    $data->save();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.transaksi_distribusi_depo')->with('success', 'Data berhasil diperbarui');
}

public function destroy($id)
{
    // Temukan data yang akan dihapus
    $data = TransaksiDepo::findOrFail($id);

    // Hapus data
    $data->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.transaksi_distribusi_depo')->with('success', 'Data berhasil dihapus');
}
    


public function import_excel(Request $request)
{
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
                        'id_cluster' => $request->id_cluster,
                        'id_depo' => $request->id_depo,
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
                    Log::warning('Barang not found for item name: ' . $d['item_name']);
                }
            }
        }

        // Redirect back with success message
        return redirect()->route('admin.transaksi.distribusi_depo')->with('success', 'Barang masuk telah ditambahkan');
    }
}
}
