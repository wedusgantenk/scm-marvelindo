<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\BarangMasukImport;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Cluster;
use App\Models\DetailBarang;
use App\Models\JenisBarang;
use App\Models\Petugas;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class BarangMasukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = BarangMasuk::with('petugas', 'barang', 'jenis_barang', 'cluster')->get();
        return view('admin.barang_masuk.index', compact('data'));
    }

    public function create()
    {
        $petugas = Petugas::all();
        $barang = Barang::all();
        $jenis_barang = JenisBarang::all();
        $cluster = Cluster::all();
        return view('admin.barang_masuk.create', compact('jenis_barang', 'petugas', 'barang', 'cluster'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'id_produk' => 'required',
                'id_petugas' => 'required',
                'tanggal' => 'required',
                'no_do' => 'required',
                'no_po' => 'required',
                'kode_cluster' => 'required',
            ]
        );
        BarangMasuk::create([
            'id_produk' => $request->id_produk,
            'id_petugas' => $request->id_petugas,
            'tanggal' => $request->tanggal,
            'no_do' => $request->no_do,
            'no_po' => $request->no_po,
            'kode_cluster' => $request->kode_cluster,
        ]);
        return redirect()->route('admin.barang_masuk')->with('success', 'barang telah ditambahkan');
    }

    public function edit($id)
    {
        $data = BarangMasuk::findorfail($id);
        $jenis_barang = JenisBarang::all();
        $petugas = Petugas::all();
        $barang = Barang::all();
        $cluster = Cluster::all();

        return view('admin.barang_masuk.edit', compact('data', 'jenis_barang', 'petugas', 'barang', 'cluster'));
    }

    public function update(Request $request, $id)
    {
        $data = BarangMasuk::find($id);
        $request->validate(
            [
                'nama' => 'required',
                'id_jenis' => 'required|numeric',
                'fisik' => ['in:1,0']
            ],
            [
                'nama.required' => 'Nama barang harus diisi',
                'id_jenis.required' => 'Jenis barang harus dipilih',
                'id_jenis.numeric' => 'Jenis barang harus dipilih',
            ]
        );
        if ($data->nama != $request->nama) {
            $request->validate(
                [
                    'nama' => 'unique:barang',
                ],
                [
                    'nama.unique' => 'nama barang sudah ada',
                ]
            );
        }
        $data->update([
            'id_produk' => $request->id_produk,
            'id_petugas' => $request->id_petugas,
            'tanggal' => $request->tanggal,
            'no_do' => $request->no_do,
            'no_po' => $request->no_po,
            'kode_cluster' => $request->kode_cluster,
        ]);

        return redirect()->route('admin.barang_masuk')->with('success', 'barang telah diubah');
    }

    public function destroy($id)
    {
        BarangMasuk::find($id)->delete();
        return redirect()->route('admin.barang_masuk')->with('success', 'barang telah dihapus');
    }

    public function import()
    {
        return view('admin.barang_masuk.import');
    }

    public function export()
    {
        $file = time() . '-Barang Masuk.xlsx';
        return (new FastExcel(BarangMasuk::all()))->download($file, function ($barangmasuk) {
            return [
                'nama_barang' => $barangmasuk->barang->nama,
                'tanggal' => $barangmasuk->tanggal,
                'no_do' => $barangmasuk->no_do,
                'no_po' => $barangmasuk->no_po,
                'kode_cluster' => $barangmasuk->kode_cluster,
                'petugas' => $barangmasuk->petugas->username,
            ];
        });
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

        // Move the file to the 'file_barang' folder within the 'public' directory
        $file->move(public_path('file_barang'), $nama_file);

        // Import data from the uploaded file
        $filePath = public_path('file_barang/' . $nama_file);
        if (!file_exists($filePath)) {
            return back()->withErrors(['file' => 'File upload failed or file path is incorrect.']);
        }

        $data = Excel::toCollection(new BarangMasukImport, $filePath);

        foreach ($data as $dat) {
            foreach ($dat as $d) {
                $kode_cluster = strtolower(explode('_', $d['gudang'])[1]);

                $data_barang = Barang::firstOrCreate([
                    'id_jenis' => 1,
                    'nama' => $d['item_name'],
                    'keterangan' => 'isi deskripsi produk',
                    'fisik' => 1,
                ]);

                $data_barang_masuk = BarangMasuk::firstOrCreate([
                    'id_produk' => $data_barang['id'],
                    'id_petugas' => Auth::user()->id,
                    'tanggal' => $d['tgl_good_receive'],
                    'no_do' => $d['no_do'],
                    'no_po' => $d['no_po'],
                    'kode_cluster' => $kode_cluster
                ]);

                $data_detail_barang = DetailBarang::firstOrCreate([
                    'id_barang' => $data_barang['id'],
                    'id_barang_masuk' => $data_barang_masuk['id'],
                    'kode_unik' => $d['iccid'],
                    'status' => '1'
                ]);
            }
        }

        // Redirect back with success message
        return redirect()->route('admin.brg_masuk')->with('success', 'Barang masuk telah ditambahkan');
    }
}
