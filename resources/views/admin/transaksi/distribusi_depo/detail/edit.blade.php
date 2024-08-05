@extends('layouts.index')

@section('title')
Edit Detail Transaksi Depo
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 p-6 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Edit Detail Transaksi</h6>
                </div>
                <div class="flex-auto ">
                    <form action="{{ route('admin.transaksi.distribusi_depo.detail.update', $data['id']) }}" method="POST" enctype="multipart/form-data" role="form">
                        @csrf
                        @method('PATCH')
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">ID Transaksi</label>
                        <div class="mb-4">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="id_transaksi" name="id_transaksi" required>
                                <option value="">-- Pilih --</option>
                                @foreach($transaksi as $dp)
                                <option value="{{ $dp['id'] }}" {{ old('id_transaksi', $data['id_transaksi']) == $dp['id'] ? 'selected' : '' }}>
                                    {{ $dp['id'] }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_lokasi_asal')
                            <span id="cluster-addon" class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Nama Barang</label>
                        <div class="mb-3">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="id_barang" aria-describedby="id_barang" id="id_barang" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($barang as $brg)
                                <option value="{{ $brg['id'] }}" {{ old('id_barang', $data['id_barang']) == $brg['id'] ? 'selected' : '' }}>
                                    {{ $brg['nama'] }}
                                </option>
                                @endforeach
                            </select>
                            @error('petugas')
                            <span id="btsHelp" class="invalid-feedback" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                            @enderror
                        </div>

                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Kode Unik</label>
                        <div class="mb-4">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12 search-select" id="kode_unik" name="kode_unik" required>
                                <option value="">-- Pilih Kode Unik --</option>
                                @foreach($detail as $dtl)
                                <option value="{{ $dtl['kode_unik'] }}" {{ old('kode_unik', $data['kode_unik']) == $dtl['kode_unik'] ? 'selected' : '' }}>
                                    {{ $dtl['kode_unik'] }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_lokasi_asal')
                            <span id="cluster-addon" class="invalid-feedback" role="alert">{{ $message }}</span>
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

<script>
    $(document).ready(function() {
        $('.search-select').select2();
    });
</script>
@endsection
