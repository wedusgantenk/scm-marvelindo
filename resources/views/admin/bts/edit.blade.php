@extends('layouts.index')

@section('title')
Edit BTS
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border p-6">
                <div class="border-b-0 border-b-solid rounded-t-2xl border-b-transparent font-semibold">
                    <h6>Edit {{ $data['nama'] }}</h6>
                </div>
                <div class="flex-auto ">
                    <form action="{{ route('admin.bts.update', $data['id']) }}" method="post" enctype="multipart/form-data" role="form">
                        @csrf
                        @method('PATCH')
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Nama BTS</label>
                        <div class="mb-4">
                            <input type="text" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-csite bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-20" aria-describedby="cluster-addon" autocomplete="off" value="{{ $data['nama'] }}" name="nama" required>
                            @error('nama')
                            <span id="cluster-addon" class="invalid-feedback" role="alert"></span>
                            <small>{{ $message }}</small>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Alamat</label>
                        <div class="mb-4">
                            <textarea class="form-control @error('alamat') is-invalid @enderror flex-auto resize-none focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow" placeholder="Alamat" aria-label="Alamat" aria-describedby="alamat-addon" name="alamat" id="inputAlamat" rows="3">{{ $data['alamat'] }}</textarea>
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Longitude</label>
                        <div class="mb-4">
                            <input type="text" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-csite bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-20" id="inputCluster" placeholder="Masukkan longitude" aria-label="cluster" aria-describedby="cluster-addon" autocomplete="off" value="{{ $data['lang'] }}" name="long" required>
                            @error('long')
                            <span id="cluster-addon" class="invalid-feedback" role="alert"></span>
                            @enderror
                        </div>
                        <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Latitude</label>
                        <div class="mb-4">
                            <input type="text" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-csite bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-20" id="inputCluster" placeholder="Masukkan latitude" aria-label="cluster" aria-describedby="cluster-addon" autocomplete="off" value="{{ $data['lat'] }}" name="lat" required>
                            @error('lat')
                            <span id="cluster-addon" class="invalid-feedback" role="alert"></span>
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
