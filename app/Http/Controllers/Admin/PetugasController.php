<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\Depo;
use App\Models\Petugas;
use App\Models\User;
use GuzzleHttp\Client;
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
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/petugas";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.petugas.index', ['data' => $data]);
    }

    public function create()
    {
        $clienta = new Client;
        $urla = "http://scmapi.satriatech.com/api/admin/cluster";
        $responsea = $clienta->request('GET', $urla);
        $contenta = $responsea->getBody()->getContents();
        $contentArraya = json_decode($contenta, true);
        $cluster = $contentArraya['data'];

        $clientb = new Client;
        $urlb = "http://scmapi.satriatech.com/api/admin/depo";
        $responseb = $clientb->request('GET', $urlb);
        $contentb = $responseb->getBody()->getContents();
        $contentArrayb = json_decode($contentb, true);
        $depo = $contentArrayb['data'];
        return view('admin.petugas.create', compact('cluster', 'depo'));
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

        $parameter = [
            'username' => $request->username,
            'hak_akses' => $request->role,
            'password'  => Hash::make($request->password),
            'jenis' => $jenis,
            'bagian' => $request->bagian,
        ];
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/petugas";
        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($parameter)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        return redirect()->route('admin.petugas')->with('success', 'User ' . $request->name . ' telah ditambahkan');
    }

    public function edit($id)
    {
        $client = new Client;
        $url = "http://scmapi.satriatech.com/api/admin/petugas/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];

        $clienta = new Client;
        $urla = "http://scmapi.satriatech.com/api/admin/cluster";
        $responsea = $clienta->request('GET', $urla);
        $contenta = $responsea->getBody()->getContents();
        $contentArraya = json_decode($contenta, true);
        $cluster = $contentArraya['data'];

        $clientb = new Client;
        $urlb = "http://scmapi.satriatech.com/api/admin/depo";
        $responseb = $clientb->request('GET', $urlb);
        $contentb = $responseb->getBody()->getContents();
        $contentArrayb = json_decode($contentb, true);
        $depo = $contentArrayb['data'];

        if (!isset($contentArray['status']) || $contentArray['status'] !== true) {
            $error = isset($contentArray['message']) ? $contentArray['message'] : "Unknown error occurred";
            return redirect()->route('admin.petugas')->withErrors($error);
        } else {
            $data = $contentArray['data'];
            $cluster = $contentArraya['data'];
            $depo = $contentArrayb['data'];

            return view('admin.petugas.edit', compact('data', 'cluster', 'depo'));
        }
    }

    public function update(Request $request, $id)
    {
        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/petugas/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
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
        $client->request('PUT', $url, [
            'json' => $dataToUpdate,
        ]);
        return redirect()->route('admin.petugas')->with('success', 'User ' . $request->name . ' telah dubah');
    }
    public function destroy($id)
    {

        $client = new Client();
        $url = "http://scmapi.satriatech.com/api/admin/petugas/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        return redirect()->route('admin.petugas')->with('success', 'petugas telah dihapus');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
