@extends('layouts.index')

@section('title')
Tambah Outlet
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 p-6 mb-6 break-words border-0 border-transparent border-solid bg-csite shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparentxl rounded-2xl bg-clip-border">
          <h6 class="text-s">Tambah Outlet</h6>
        </div>
        <div class="flex-auto ">
          <form action="{{ route('admin.outlet.store') }}" method="POST" enctype="multipart/form-data" role="form">
            @csrf
            <label class="mb-2 ml-1 text-xs font-bold text-slate-700" for="bts_id">Pilih BTS</label>
            <div class="mb-3">
              <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="bts_id" aria-describedby="btsHelp" id="bts_id" required>
                <option value="">-- Pilih --</option>
                @foreach ($bts as $bt)
                <option value="{{ $bt['id'] }}">{{ $bt['nama'] }}</option>
                @endforeach
              </select>
              @error('bts_id')
              <span id="btsHelp" class="invalid-feedback" role="alert">
                <small>{{ $message }}</small>
              </span>
              @enderror
            </div>
            <label class="mb-2 ml-1 text-xs font-bold text-slate-700" for="jenis_id">Pilih Depo</label>
            <div class="mb-3">
              <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="depo_id" aria-describedby="btsHelp" id="depo_id" required>
                <option value="">-- Pilih --</option>
                @foreach ($depo as $dp)
                <option value="{{ $dp['id'] }}">{{ $dp['nama'] }}</option>
                @endforeach
              </select>
              @error('depo_id')
              <span id="btsHelp" class="invalid-feedback" role="alert">
                <small>{{ $message }}</small>
              </span>
              @enderror
            </div>
            <label class="mb-2 ml-1 text-xs font-bold text-slate-700" for="jenis_id">Pilih Jenis Outlet</label>
            <div class="mb-3">
              <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" name="jenis_id" aria-describedby="btsHelp" id="jenis_id" required>
                <option value="">-- Pilih --</option>
                @foreach ($jenis_outlet as $jenis)
                <option value="{{ $jenis['id'] }}">{{ $jenis['nama'] }}</option>
                @endforeach
              </select>
              @error('jenis_id')
              <span id="btsHelp" class="invalid-feedback" role="alert">
                <small>{{ $message }}</small>
              </span>
              @enderror
            </div>
            <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Nama Outlet</label>
            <div class="mb-4">
              <input type="text" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12" id="inputDepo" placeholder="Masukkan nama depo" aria-label="depo" aria-describedby="depo-addon" autocomplete="off" value="{{ old('nama')}}" name="nama" required>
              @error('nama')
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
@endsection
