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
    


// public function import_excel_old(Request $request)
// {
//     {
//         // Validate the request
//         $this->validate($request, [
//             'file' => 'required|mimes:csv,xls,xlsx'
//         ]);

//         // Capture the uploaded file
//         $file = $request->file('file');


//         // Create a unique file name
//         $nama_file = rand() . "_" . $file->getClientOriginalName();

//         // Move the file to the 'distribusi_depo' folder within the 'public' directory
//         $file->move(public_path('distribusi_depo'), $nama_file);

//         // Construct the file path
//         $filePath = public_path('distribusi_depo/' . $nama_file);

//         // Check if the file exists after moving it
//         if (!file_exists($filePath)) {
//             return back()->withErrors(['file' => 'File upload failed or file path is incorrect.']);
//         }

//         // Import data from the uploaded file
//         try {
//             $data = Excel::toCollection(new TransaksiDepoImport, $filePath);
//             // Debug: Display the imported data
//             dd($data);
            
//         } catch (\Exception $e) {
//             return back()->withErrors(['file' => 'Error during Excel import: ' . $e->getMessage()]);
//         }

//         foreach ($data as $dat) {
//             foreach ($dat as $d) {
//                 $barang = Barang::where('nama', $d['nama'])->first();

//                 if ($barang) {
//                     $transaksi = TransaksiDepo::firstOrCreate([
//                         'id_petugas' => Auth::user()->id,
//                         'id_cluster' => $request->id_cluster,
//                         'id_depo' => $request->id_depo,
//                         'tanggal' => date('Y-m-d'),
//                         'status' => '',
//                     ]);

//                     TransaksiDepoDetail::firstOrCreate([
//                         'id_transaksi' => $transaksi->id,
//                         'id_barang' => '',
//                         'kode_unik' => $d['iccid'],
//                     ]);
//                 } else {
//                     // Log or handle the case where the item does not exist
//                     Log::warning('Barang not found for item name: ' . $d['barang']);
//                 }
//             }
//         }

//         // Redirect back with success message
//         return redirect()->route('admin.transaksi.distribusi_depo')->with('success', 'Barang masuk telah ditambahkan');
//     }
// }

//sadwadawdwad
public function import_excel(Request $request)
{
    // Validate the incoming request
    $this->validate($request, [
        'file' => 'required|file|mimes:csv,xls,xlsx', // Contoh validasi tambahan untuk ID Sales
        'id_depo' => 'required|exists:depo,id', // Contoh validasi tambahan untuk ID Depo
        'id_petugas' => 'required|exists:petugas,id',
        'id_cluster' => 'required|exists:cluster,id'

    ]);

    // Retrieve the file from the request
    $file = $request->file('file');

    // Generate a unique file name
    $nama_file = rand() . "_" . $file->getClientOriginalName();

    // Move the file to a directory within the storage folder
    $destinationPath = storage_path('app/public/excel_transaksi_depo');
    $file->move($destinationPath, $nama_file);

    // Start a database transaction
    DB::beginTransaction();


    try {
        // Import data using Laravel Excel
        $import = new TransaksiDepoImport;

        Excel::import($import, $destinationPath . '/' . $nama_file);

        // Get the imported data
        $importedData = $import->getData();



        // Save each imported row to the database
        foreach ($importedData as $collection) {
            $row = $collection->toArray();


            ############ mencari barang merujuk pada item_name
            // Mencari barang berdasarkan nama
            $barang = Barang::where('nama', $row['ITEM NAME'])->first();
            
            $userId = Auth::id();

            TransaksiDepo::create([
                'id_petugas' => $userId,
                'id_cluster' => $request->id_cluster,
                'id_depo' => $request->id_depo,
                'tanggal' => Carbon::now(),
                'status' => ''
      
            ]);

            
            $now = Carbon::now();
             // Format kode dengan format DDMMYYMinutesMinutesHH
            $transaksiCode = $now->format('d') . $now->format('m') . $now->format('y') . $now->format('i') . $now->format('i') . $now->format('H');
            TransaksiDepoDetail::firstOrCreate([
                'id_transaksi' => $row['id_transaksi'],
                'transaksi_code' => $transaksiCode,
                'id_barang' => $barang->id,
                'kode_unik' => $row['ICCID'],
                'status' => ''
            ]);

        }

        // Commit the transaction
        DB::commit();

        // Delete the file after processing
        unlink($destinationPath . '/' . $nama_file);

        // Return a success message
        return redirect()->route('admin.transaksi_distribusi_depo')->with('success', 'File has been successfully imported and data saved to the database.');
    } catch (\Exception $e) {
        // Rollback the transaction
        DB::rollBack();

        // Delete the file in case of an error
        if (file_exists($destinationPath . '/' . $nama_file)) {
            unlink($destinationPath . '/' . $nama_file);
        }

        // Log the error
        Log::error('Error importing file: ' . $e->getMessage());

        // Return an error message
        return redirect()->back()->with('error', 'There was an error processing your file. ' . $e->getMessage());
    }
}


}
