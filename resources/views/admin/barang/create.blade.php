@extends('layouts.index')

@section('title')
Tambah Barang
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 p-6 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Tambah Barang</h6>
                </div>
                <div class="flex-auto">
                    <form id="barang" action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data" role="form">
                        @csrf
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Nama Barang</label>
                        <div class="mb-4">
                            <input type="text" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="inputBarang" placeholder="Masukkan nama barang" aria-label="barang" aria-describedby="barang-addon" autocomplete="off" value="{{ old('nama')}}" name="nama" required>
                            @error('nama')
                            <span id="cluster-addon" class="invalid-feedback" role="alert"></span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Jenis Barang</label>
                        <div class="mb-3">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="id_jenis" aria-describedby="btsHelp" id="id_jenis" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($jenis_barang as $jenis)
                                <option value="{{ $jenis['id'] }}">{{ $jenis['nama'] }}</option>
                                @endforeach
                            </select>
                            @error('id_jenis')
                            <span id="btsHelp" class="invalid-feedback" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <input id="fisik" name="fisik" value="1" class="w-5 h-5 text-red-600 rounded-md" type="checkbox" checked />
                            <label for="fisik" class="mb-2 ml-1 text-xs font-bold text-slate-700">Fisik</label>
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Upload Foto</label>
                        <div class="mb-4">
                        <input type="file" name="gambar" id="gambar" class="block max-w-full mt-1 rounded-md shadow-sm focus:ring-red-500 sm:text-sm focus:border-red-300" accept="image/*" required>
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Keterangan</label>
                        <div class="mb-4">
                            <textarea class="flex-auto resize-none focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow" placeholder="Keterangan" aria-label="Alamat" aria-describedby="alamat-addon" name="keterangan" id="inputAlamat" rows="3">{{ old('alamat')}}</textarea>
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
