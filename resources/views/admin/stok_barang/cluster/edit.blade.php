@extends('layouts.index')

@section('title')
Edit Stok Barang {{ $data->cluster->nama }}
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border p-6">
                <div class="border-b-0 border-b-solid rounded-t-2xl border-b-transparent font-semibold">
                    <h6>Edit Stok Barang {{ $data->cluster->nama }}</h6>
                </div>
                <div class="flex-auto ">
                    <form action="{{ route('admin.stok_barang.cluster.update', $data->id) }}" method="POST" enctype="multipart/form-data" role="form">
                        @csrf
                        @method('PATCH')
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Nama Cluster</label>
                        <div class="mb-4">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="inputNamaBarang" name="id_cluster" required>
                                <option value="">Pilih Lokasi Cluster</option>
                                @foreach($cluster as $cls)
                                <option value="{{ $cls->id }}">{{ $cls->nama }}</option>
                                @endforeach
                            </select>
                            @error('kode_histori_barang')
                            <span id="histori_barang-addon" class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Jumlah Stok Barang</label>
                        <div class="mb-4">
                            <input type="number" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="inputHistoriBarang" placeholder="Masukkan ICCID" aria-label="Histori_barang" aria-describedby="Histori_barang-addon" autocomplete="off" value="{{ $data->stok }}" name="stok" required>
                            @error('stok')
                            <span id="Histori_barang-addon" class="invalid-feedback" role="alert"></span>
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
