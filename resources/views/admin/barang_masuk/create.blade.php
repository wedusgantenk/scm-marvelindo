@extends('layouts.index')

@section('title')
Tambah Barang
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border p-6">
                <div class="border-b-0 border-b-solid rounded-t-2xl border-b-transparent font-semibold">
                    <h6>Tambah Barang</h6>
                </div>
                <div class="flex-auto ">
                    <form id="barang" action="{{ route('admin.barang_masuk.store') }}" method="POST" enctype="multipart/form-data" role="form">
                        @csrf
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Tanggal</label>
                        <div class="mb-4">
                            <input type="date" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="tanggal" placeholder="Masukkan nama barang" aria-label="tanggal" aria-describedby="barang-addon" autocomplete="off" value="{{ old('tanggal')}}" name="tanggal" required>
                            @error('tanggal')
                            <span id="cluster-addon" class="invalid-feedback" role="alert"></span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Nama Barang</label>
                        <div class="mb-4">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="id_produk" aria-describedby="btsHelp" id="id_produk" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($barang as $jb)
                                <option value="{{ $jb->id }}">{{ $jb->nama }}</option>
                                @endforeach
                            </select>
                            @error('nama')
                            <span id="cluster-addon" class="invalid-feedback" role="alert"></span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Kode Cluster</label>
                        <div class="mb-4">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="kode_cluster" aria-describedby="btsHelp" id="kode_cluster" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($cluster as $cl)
                                <option value="{{ $cl->id }}">{{ $cl->kode_cluster }}</option>
                                @endforeach
                            </select>
                            @error('kode_cluster')
                            <span id="cluster-addon" class="invalid-feedback" role="alert"></span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Nomor DO</label>
                        <div class="mb-4">
                            <input type="text" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="no_do" placeholder="Masukkan nomor DO" aria-label="barang" aria-describedby="barang-addon" autocomplete="off" value="{{ old('no_do')}}" name="no_do" required>
                            @error('nama')
                            <span id="cluster-addon" class="invalid-feedback" role="alert"></span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Nomor PO</label>
                        <div class="mb-4">
                            <input type="text" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="inputBarang" placeholder="Masukkan nama barang" aria-label="barang" aria-describedby="barang-addon" autocomplete="off" value="{{ old('no_po')}}" name="no_po" required>
                            @error('nama')
                            <span id="cluster-addon" class="invalid-feedback" role="alert"></span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Petugas</label>
                        <div class="mb-3">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="id_petugas" aria-describedby="btsHelp" id="petugas" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($petugas as $ptg)
                                <option value="{{ $ptg->id }}">{{ $ptg->username }}</option>
                                @endforeach
                            </select>
                            @error('petugas')
                            <span id="btsHelp" class="invalid-feedback" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="inline-block px-6 py-3 mt-6 mb-6 text-xs font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer min-w-12 bg-slate-700 text-csite shadow-soft-md bg-x-25 bg-150 leading-pro ease-soft-in tracking-tight-soft bg-gradient-to-tl from-pink-800 to-red-500 hover:scale-102 hover:shadow-soft-xs active:opacity-85">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
