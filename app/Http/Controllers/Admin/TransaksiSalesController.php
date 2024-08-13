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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiSalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transaksiDistribusiSales = TransaksiSales::with('depo', 'sales')->get();
        return view('admin.transaksi.distribusi_sales.index', compact('transaksiDistribusiSales'));
    }

    public function create()
    {
        
    }

    public function show($id)
    {
        $transaksiDistribusiSale = TransaksiSales::with(['petugas', 'sales'])->findOrFail($id);
        return view('admin.transaksi.distribusi_sales.detail.index', compact('transaksiDistribusiSale'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_petugas' => 'required|int|exists:petugas,id',
            'id_depo' => 'required|int|exists:depo,id',
            'id_sales' => 'required|int|exists:sales,id',
            'tanggal' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

          // Jika validasi gagal
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }


    $data = new TransaksiSales();
    
    $data->id_petugas = $request->id_petugas;
    $data->id_depo = $request->id_depo;
    $data->id_sales = $request->id_sales;
    $data->tanggal = $request->tanggal;
    $data->status = $request->status;

    $data->save();

    return redirect()->route('admin.transaksi_distribusi_sales')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        // Validasi data menggunakan Validator
        $validator = Validator::make($request->all(), [
            'id_petugas' => 'required|int|exists:petugas,id',
            'id_depo' => 'required|int|exists:depo,id',
            'id_sales' => 'required|int|exists:sales,id',
            'tanggal' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Temukan data yang akan diupdate
    $data = TransaksiSales::findOrFail($id);
    
    // Update data
    $data->id_petugas = $request->id_petugas;
    $data->id_depo = $request->id_depo;
    $data->id_sales = $request->id_sales;
    $data->tanggal = $request->tanggal;
    $data->status = $request->status;
    $data->save();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.transaksi_distribusi_sales')->with('success', 'Data berhasil diperbarui');
}


public function destroy($id)
{
    // Temukan data yang akan dihapus
    $data = TransaksiSales::findOrFail($id);

    // Hapus data
    $data->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.transaksi_distribusi_sales')->with('success', 'Data berhasil dihapus');
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

    // public function import_excel(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'file' => 'required|mimes:csv,xls,xlsx'
    //     ]);

    //     // Capture the uploaded file
    //     $file = $request->file('file');

    //     // Create a unique file name
    //     $nama_file = rand() . "_" . $file->getClientOriginalName();

    //     // Move the file to the 'distribusi_sales' folder within the 'public' directory
    //     $file->move(public_path('distribusi_sales'), $nama_file);

    //     // Construct the file path
    //     $filePath = public_path('distribusi_sales/' . $nama_file);

    //     // Check if the file exists after moving it
    //     if (!file_exists($filePath)) {
    //         return back()->withErrors(['file' => 'File upload failed or file path is incorrect.']);
    //     }

    //     // Import data from the uploaded file
    //     try {
    //         $data = Excel::toCollection(new TransaksiSalesImport, $filePath);
    //     } catch (\Exception $e) {
    //         return back()->withErrors(['file' => 'Error during Excel import: ' . $e->getMessage()]);
    //     }

    //     foreach ($data as $sheet) {
    //         foreach ($sheet as $row) {
    //             $barang = Barang::where('nama', $row['item_name'])->first();

    //             if ($barang) {
    //                 $id_depo = $request->depo_id;
    //                 $kode_unik = $row['iccid'];

    //                 $barang_depo_exists = TransaksiSales::whereHas('details', function ($query) use ($kode_unik) {
    //                     $query->where('kode_unik', $kode_unik);
    //                 })->where('id_depo', $id_depo)->exists();

    //                 if (!$barang_depo_exists) {
    //                     $transaksi = TransaksiSales::firstOrCreate([
    //                         'id_petugas' => Auth::user()->id,
    //                         'id_sales' => $request->sales_id,
    //                         'id_depo' => $request->depo_id,
    //                         'tanggal' => date('Y-m-d'),
    //                         'status' => '',
    //                     ]);

    //                     TransaksiSalesDetail::firstOrCreate([
    //                         'id_transaksi' => $transaksi->id,
    //                         'id_barang' => $barang->id,
    //                         'kode_unik' => $row['iccid'],
    //                     ]);
    //                 } else {
    //                     \Log::warning('Barang already exists in the selected depo for kode_unik: ' . $kode_unik);
    //                 }
    //             } else {
    //                 \Log::warning('Barang not found for item name: ' . $row['item_name']);
    //             }
    //         }
    //     }

    //     // Redirect back with success message
    //     return redirect()->route('admin.transaksi.distribusi_sales')->with('success', 'Barang masuk telah ditambahkan');
    // 



    // new import_excel

    public function import_excel(Request $request)
{
    // Validate the incoming request
    $this->validate($request, [
        'file' => 'required|file|mimes:csv,xls,xlsx', // Contoh validasi tambahan untuk ID Sales
        'id_depo' => 'required|exists:depo,id', // Contoh validasi tambahan untuk ID Depo
        'id_petugas' => 'required|exists:petugas,id',
        'id_sales' => 'required|exists:sales,id'

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
        $import = new TransaksiSalesImport;

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

            TransaksiSales::create([
                'id_petugas' => $userId,
                'id_sales' => $request->id_sales,
                'id_depo' => $request->id_depo,
                'tanggal' => Carbon::now(),
                'status' => ''
      
            ]);

            
            $now = Carbon::now();
             // Format kode dengan format DDMMYYMinutesMinutesHH
            $transaksiCode = $now->format('d') . $now->format('m') . $now->format('y') . $now->format('i') . $now->format('i') . $now->format('H');
            TransaksiSalesDetail::firstOrCreate([
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
