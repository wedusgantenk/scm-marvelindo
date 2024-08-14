<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\BarangMasukImport;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\DetailBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

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

    public function import_excel(Request $request)
    {
        // Validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // Menangkap file excel
        $file = $request->file('file');
        $nama_file = rand() . "_" . $file->getClientOriginalName();
        $file->move('file_barang', $nama_file);

        try {
            // Mulai transaksi
            DB::beginTransaction();

            // Import data
            $data = Excel::toCollection(new BarangMasukImport, public_path('/file_barang/' . $nama_file));

            foreach ($data as $dat) {
                foreach ($dat as $d) {
                    $kode_cluster = strtolower(explode('_', $d['gudang'])[1]);

                    $data_barang = Barang::firstOrCreate([
                        'id_jenis' => 1,
                        'nama' => $d['item_name'],
                        'keterangan' => 'deskripsi produk',
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

            // Commit transaksi
            DB::commit();

            // Hapus file yang diupload setelah berhasil
            @unlink(public_path('/file_barang/' . $nama_file));

            // Kembalikan respons JSON
            return response()->json(['success' => true, 'message' => 'Data barang masuk berhasil ditambahkan']);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error during import: ' . $e->getMessage());

            DB::rollback();
            @unlink(public_path('/file_barang/' . $nama_file));

            // Kembalikan respons JSON dengan pesan error
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengimpor data. Data tidak berhasil diinput.',
                'error' => $e->getMessage() // Menambahkan detail error
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->input('id');

            // Temukan data BarangMasuk dengan ID dan hapus
            $barangMasuk = BarangMasuk::findOrFail($id);

            // Hapus detail barang terkait
            DetailBarang::where('id_barang_masuk', $barangMasuk->id)->delete();

            // Hapus data BarangMasuk
            $barangMasuk->delete();

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            // Log error jika perlu
            Log::error('Gagal menghapus data: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Gagal menghapus data']);
        }
    }
}
