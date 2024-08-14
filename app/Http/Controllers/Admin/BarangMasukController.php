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
        // Validasi permintaan
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // Ambil file yang diunggah
        $file = $request->file('file');

        // Buat nama file unik
        $nama_file = rand() . "_" . $file->getClientOriginalName();

        // Pindahkan file ke folder 'file_barang' dalam direktori 'public'
        $file->move(public_path('file_barang'), $nama_file);

        // Impor data dari file yang diunggah
        $filePath = public_path('file_barang/' . $nama_file);
        if (!file_exists($filePath)) {
            return back()->withErrors(['file' => 'Unggah file gagal atau jalur file tidak benar.']);
        }

        $data = Excel::toCollection(new BarangMasukImport, $filePath);

        $duplicateCount = 0;

        foreach ($data as $dat) {
            foreach ($dat as $d) {
                $kode_cluster = strtolower(explode('_', $d['gudang'])[1]);

                $data_barang = Barang::firstOrCreate([
                    'id_jenis' => 1,
                    'nama' => $d['item_name'],
                    'keterangan' => 'isi deskripsi produk',
                    'fisik' => 1,
                ]);

                $existingBarangMasuk = BarangMasuk::where([
                    'id_produk' => $data_barang['id'],
                    'tanggal' => $d['tgl_good_receive'],
                    'no_do' => $d['no_do'],
                    'no_po' => $d['no_po'],
                    'kode_cluster' => $kode_cluster
                ])->first();

                if ($existingBarangMasuk) {
                    $duplicateCount++;
                    continue;
                }

                $data_barang_masuk = BarangMasuk::create([
                    'id_produk' => $data_barang['id'],
                    'id_petugas' => Auth::user()->id,
                    'tanggal' => $d['tgl_good_receive'],
                    'no_do' => $d['no_do'],
                    'no_po' => $d['no_po'],
                    'kode_cluster' => $kode_cluster
                ]);

                $existingDetailBarang = DetailBarang::where('kode_unik', $d['iccid'])->first();

                if ($existingDetailBarang) {
                    $duplicateCount++;
                    continue;
                }

                DetailBarang::create([
                    'id_barang' => $data_barang['id'],
                    'id_barang_masuk' => $data_barang_masuk['id'],
                    'kode_unik' => $d['iccid'],
                    'status' => '1'
                ]);
            }
        }

        // Redirect kembali dengan pesan sukses dan peringatan jika ada duplikat
        if ($duplicateCount > 0) {
            return redirect()->route('admin.barang_masuk')
                ->with('success', 'Barang masuk telah ditambahkan')
                ->with('warning', "Terdapat $duplicateCount data duplikat yang dilewati.");
        } else {
            return redirect()->route('admin.barang_masuk')->with('success', 'Barang masuk telah ditambahkan');
        }
    }
}
