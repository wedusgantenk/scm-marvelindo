<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bts;
use Illuminate\Http\Request;

class BtsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Bts::all();
        return view('admin.bts.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:bts',
        ]);

        $bts = new Bts();
        $bts->nama = $request->nama;
        $bts->alamat = $request->alamat;
        $bts->lang = $request->long;
        $bts->lat = $request->lat;
        $bts->save();

        if ($request->ajax()) {
            return response()->json(['success' => 'BTS telah ditambahkan']);
        }

        return redirect()->route('admin.bts')->with('success', 'BTS telah ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $bts = Bts::findOrFail($id);
        $request->validate([
            'nama' => 'required',
        ]);
        if ($bts->nama != $request['nama']) {
            $request->validate([
                'nama' => 'unique:bts',
            ]);
        }

        $bts->nama = $request->nama;
        $bts->alamat = $request->alamat;
        $bts->lang = $request->long;
        $bts->lat = $request->lat;
        $bts->save();

        if ($request->ajax()) {
            return response()->json(['success' => 'BTS telah diubah']);
        }

        return redirect()->route('admin.bts')->with('success', 'BTS telah diubah');
    }

    public function destroy($id, Request $request)
    {
        $bts = Bts::findOrFail($id);
        $bts->delete();

        if ($request->ajax()) {
            return response()->json(['success' => 'BTS telah dihapus']);
        }

        return redirect()->route('admin.bts')->with('success', 'BTS telah dihapus');
    }
}
