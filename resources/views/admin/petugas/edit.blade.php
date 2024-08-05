@extends('layouts.index')

@section('title')
Edit Petugas
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border p-6">
                <div class="border-b-0 border-b-solid rounded-t-2xl border-b-transparent font-semibold">
                    <h6>Edit Petugas</h6>
                </div>
                <div class="flex-auto ">
                    <form action="{{ route('admin.petugas.update', $data['id']) }}" method="POST" enctype="multipart/form-data" role="form">
                        @csrf
                        @method('PATCH')
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Nama petugas</label>
                        <div class="mb-4">
                            <input type="text" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="username" placeholder="Masukkan nama petugas" aria-label="petugas" aria-describedby="petugas-addon" autocomplete="off" value="{{ $data['username'] }}" name="username" required>
                            @error('username')
                            <span id="username" class="invalid-feedback" role="alert"></span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Hak Akses</label>
                        <div class="mb-4">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="role" aria-describedby="clusterHelp" id="role" required onchange="showSubDropdown()">
                                <option value="">-- Pilih --</option>
                                <option value="admin" {{ $data['hak_akses'] == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="cluster" {{ $data['hak_akses'] == 'cluster' ? 'selected' : '' }}>Cluster</option>
                                <option value="depo" {{ $data['hak_akses'] == 'depo' ? 'selected' : '' }}>Depo</option>
                            </select>
                            @error('role')
                            <span id="role" class="invalid-feedback" role="alert"></span>
                            @enderror
                        </div>
                        <label id="cluster_label" style="display: none;" class="mb-2 ml-1 text-xs font-bold text-slate-700">Cluster</label>
                        <div class="mb-4">
                            <select style="display: none;" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="cluster_id" aria-describedby="clusterHelp" id="cluster_id">
                                <option value="">-- Pilih --</option>
                                @foreach ($cluster as $cs)
                                <option value="{{ $cs['id'] }}" {{ $data['jenis'] == $cs['id'] && $data['hak_akses'] == 'cluster' ? 'selected' : '' }}>{{ $cs['nama'] }}</option>
                                @endforeach
                            </select>
                            @error('cluster_id')
                            <span id="clusterHelp" class="invalid-feedback" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                            @enderror
                        </div>
                        <label id="depo_label" style="display: none;" class="mb-2 ml-1 text-xs font-bold text-slate-700">Depo</label>
                        <div class="mb-4">
                            <select style="display: none;" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="depo_id" aria-describedby="depoHelp" id="depo_id">
                                <option value="">-- Pilih --</option>
                                @foreach ($depo as $dp)
                                <option value="{{ $dp['id'] }}" {{ $data['jenis'] == $dp['id'] && $data['hak_akses'] == 'depo' ? 'selected' : '' }}>{{ $dp['nama'] }}</option>
                                @endforeach
                            </select>
                            @error('depo_id')
                            <span id="depoHelp" class="invalid-feedback" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Bagian</label>
                        <div class="mb-4">
                            <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="bagian" aria-describedby="clusterHelp" id="bagian" required>
                                <option value="">-- Pilih --</option>
                                <option value="keuangan" {{ $data['bagian'] == 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                                <option value="gudang" {{ $data['bagian'] == 'gudang' ? 'selected' : '' }}>Gudang</option>
                            </select>
                            @error('bagian')
                            <span id="bagian_text" class="invalid-feedback" role="alert"></span>
                            @enderror
                        </div>

                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Password</label>
                        <div class="mb-4">
                            <input type="password" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="password" placeholder="Masukkan password" aria-label="password" aria-describedby="password" autocomplete="off" value="{{ old('password') }}" name="password">
                            @error('password')
                            <span id="password" class="invalid-feedback" role="alert"></span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Masukkan Ulang Password</label>
                        <div class="mb-4">
                            <input type="password" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="password_confirmation" placeholder="Masukkan ulang password" aria-label="password" aria-describedby="password" autocomplete="off" value="{{ old('password_confirmation') }}" name="password_confirmation">
                            @error('password_confirmation')
                            <span id="password_confirmation" class="invalid-feedback" role="alert"></span>
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
    @endsection

    @section('js-tambahan')
    <script>
        function showSubDropdown() {
            var mainDropdown = document.getElementById("role");
            var clusterDropdown = document.getElementById("cluster_id");
            var clusterLabel = document.getElementById("cluster_label");
            var depoDropdown = document.getElementById("depo_id");
            var depoLabel = document.getElementById("depo_label");

            clusterDropdown.style.display = (mainDropdown.value === "cluster") ? "block" : "none";
            clusterLabel.style.display = (mainDropdown.value === "cluster") ? "block" : "none";
            depoDropdown.style.display = (mainDropdown.value === "depo") ? "block" : "none";
            depoLabel.style.display = (mainDropdown.value === "depo") ? "block" : "none";
        }
        showSubDropdown()
    </script>
    @endsection
