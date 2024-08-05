@extends('layouts.index')

@section('title')
Tambah Harga Barang
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 p-6 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Tambah Harga Barang</h6>
                </div>
                <div class="flex-auto ">
                    <form id="hargaBarang" action="{{ route('admin.harga_barang.store') }}" method="POST" enctype="multipart/form-data" role="form">
                        @csrf
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Nama Barang</label>
                        <div class="mb-4">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="inputNamaBarang" name="id_barang" required>
                                <option value="">Pilih Nama Barang</option>
                                @foreach($barang as $d)
                                <option value="{{ $d['id'] }}">{{ $d['nama'] }}</option>
                                @endforeach
                            </select>
                            @error('id_barang')
                            <span id="cluster-addon" class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Tanggal</label>
                        <div class="mb-4">
                            <input type="date" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="inputTanggal" name="tanggal" required>
                            @error('tanggal')
                            <span id="cluster-addon" class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Jenis Outlet</label>
                        <div class="mb-4">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="inputNamaBarang" name="id_jenis_outlet" required>
                                <option value="">Pilih Jenis Outlet</option>
                                @foreach($jenis_outlet as $d)
                                <option value="{{ $d['id'] }}">{{ $d['nama'] }}</option>
                                @endforeach

                            </select>
                            @error('id_jenis_outlet')
                            <span id="cluster-addon" class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Harga Barang</label>
                        <div class="mb-4">
                            <input type="number" class="flex-auto w-1/4 focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-csite bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow" id="harga" placeholder="Masukkan harga Barang" aria-label="depo" aria-describedby="depo-addon" autocomplete="off" value="{{ old('harga')}}" name="harga" required>
                            @error('harga')
                            <span id="depo-addon" class="invalid-feedback" role="alert"></span>
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
    document.getElementById("hargaBarang").addEventListener("submit", function(event) {
        event.preventDefault(); // Mencegah form untuk submit secara otomatis

        var hargaInput = document.getElementById("harga").value;

        // Validasi jika harga negatif
        if (hargaInput < 0) {
            alert("harga tidak boleh negatif!");
            return;
        }

        // Jika validasi berhasil, form akan disubmit
        this.submit();
    });
</script>
@endsection
