<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\Depo;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cluster = Cluster::all();
        $depo = Depo::all();
        $data = Petugas::all();
        return view('admin.petugas.index', compact('data', 'cluster', 'depo'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'username' => ['required', 'string', 'max:50'],
                'password' => ['required', 'string', 'min:5', 'confirmed'],
                'role' => ['required'],
            ],
            [
                'username.required' => 'Nama lengkap harus diisi',
                'username.string' => 'Nama lengkap harus diisi',
                'username.max' => 'Nama lengkap maksimal 50 karakter',
                'password.required' => 'Password harus diisi',
                'password.string' => 'Password harus diisi',
                'password.min' => 'Password minimal 5 karakter',
                'password.confirmed' => 'Password tidak sama dengan confirm password',
                'role.required' => 'Hak akses harus diisi',
            ]
        );

        $role = $request['role'];

        if ($role == "admin") {
            $jenis = 0;
        } else if ($role == "cluster") {
            $jenis = $request['cluster_id'];
        } else {
            $jenis = $request['depo_id'];
        }

        Petugas::create([
            'username' => $request->username,
            'hak_akses' => $request->role,
            'password'  => Hash::make($request->password),
            'jenis' => $jenis,
            'bagian' => $request->bagian,
        ]);

        return redirect()->route('admin.petugas')->with('success', 'User ' . $request->username . ' telah ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        if (isset($request->password)) {
            $request->validate([
                'username' => ['required', 'string', 'max:50'],
                'password' => ['required', 'string', 'min:5', 'confirmed'],
                'role' => ['required'],
            ]);
            $role = $request->role;

            if ($role == "admin") {
                $jenis = 0;
            } else if ($role == "cluster") {
                $jenis = $request->cluster_id;
            } else {
                $jenis = $request->depo_id;
            }

            $dataToUpdate = [
                'username' => $request->username,
                'hak_akses' => $request->role,
                'password'  => Hash::make($request->password),
                'jenis' => $jenis,
                'bagian' => $request->bagian,
            ];
        } else {
            $request->validate([
                'username' => ['required', 'string', 'max:50'],
                'role' => ['required'],
            ]);
            $role = $request->role;

            if ($role == "admin") {
                $jenis = 0;
            } else if ($role == "cluster") {
                $jenis = $request->cluster_id;
            } else {
                $jenis = $request->depo_id;
            }

            $dataToUpdate = [
                'username' => $request->username,
                'hak_akses' => $request->role,
                'jenis' => $jenis,
                'bagian' => $request->bagian,
            ];
        }

        $petugas->update($dataToUpdate);
        return redirect()->route('admin.petugas')->with('success', 'User ' . $request->username . ' telah diubah');
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();
        return redirect()->route('admin.petugas')->with('success', 'Petugas telah dihapus');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
