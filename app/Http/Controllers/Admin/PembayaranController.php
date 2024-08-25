<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Http\Controllers\Controller;
use App\Models\MobileUsers;
use Yajra\DataTables\DataTables;

class PembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Pembayaran::all();
        $users = MobileUsers::all();
        return view('admin.pembayaran.index', compact('data', 'users'));
    }


    public function getData()
    {
        $data = Pembayaran::with('user');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '<button class="btn btn-sm btn-primary edit-btn" data-id="'.$data->id.'">Edit</button> ' .
                       '<button class="btn btn-sm btn-danger hapus-btn" data-id="'.$data->id.'">Hapus</button>';
            })
            ->editColumn('status', function ($data) {
                $statusOptions = [
                    'proses' => 'Proses',
                    'dibatalkan' => 'Dibatalkan',
                    'selesai' => 'Selesai'
                ];
                return $statusOptions[$data->status] ?? $data->status;
            })
            ->editColumn('status_pembayaran', function ($data) {
                $statusPembayaranOptions = [
                    'dibayar' => 'Dibayar',
                    'belum bayar' => 'Belum Bayar'
                ];
                return $statusPembayaranOptions[$data->status_pembayaran] ?? $data->status_pembayaran;
            })
            ->editColumn('nama_outlet', function ($data) {
                $user = MobileUsers::find($data->id_user);
                return $user ? $user->nama_outlet : '-';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::find($id);

        if (!$pembayaran) {
            return response()->json(['success' => false, 'message' => 'Data pembayaran tidak ditemukan'], 404);
        }

        $request->validate([
            'status_pembayaran' => 'required|in:dibayar,belum bayar',
        ]);

        $pembayaran->status_pembayaran = $request->status_pembayaran;
        $pembayaran->save();

        return response()->json(['success' => true, 'message' => 'Status pembayaran berhasil diperbarui']);
    }
}
