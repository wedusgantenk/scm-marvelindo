@extends('layouts.index')

@section('title')
Edit Transaksi Depo
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 p-6 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Edit Transaksi Depo</h6>
                </div>
                <div class="flex-auto ">
                    <form action="{{ route('admin.transaksi.distribusi_depo.update', $data['id']) }}" method="POST" enctype="multipart/form-data" role="form">
                        @csrf
                        @method('PATCH')
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Tanggal</label>
                        <div class="mb-4">
                            <input type="date" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="inputTanggal" name="tanggal" value="{{old('tanggal', $data['tanggal'] ?? '')}}" required>
                            @error('tanggal')
                            <span id="cluster-addon" class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Cluster</label>
                        <div class="mb-4">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="inputNamaBarang" name="id_cluster" required>
                                <option value="">Pilih Cluster</option>
                                @foreach($cluster as $cls)
                                <option value="{{ $cls['id'] }}"{{ old('id_cluster', $data['id_cluster']) == $cls['id'] ? 'selected' : '' }}>{{ $cls['nama'] }}</option>
                                @endforeach
                            </select>
                            @error('id_lokasi_asal')
                            <span id="cluster-addon" class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Depo</label>
                        <div class="mb-4">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="inputNamaBarang" name="id_depo" required>
                                <option value="">Pilih Depo</option>
                                @foreach($depo as $dp)
                                <option value="{{ $dp['id'] }}"{{ old('id_depo', $data['id_depo']) == $dp['id'] ? 'selected' : '' }}>{{ $dp['nama'] }}</option>
                                @endforeach
                            </select>
                            @error('id_lokasi_asal')
                            <span id="cluster-addon" class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Petugas</label>
                        <div class="mb-3">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="id_petugas" aria-describedby="btsHelp" id="petugas" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($petugas as $ptg)
                                <option value="{{ $ptg['id'] }}"{{ old('id_petugas', $data['id_petugas']) == $ptg['id'] ? 'selected' : '' }}>{{ $ptg['username'] }}</option>
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
