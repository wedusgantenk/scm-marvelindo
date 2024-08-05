@extends('layouts.index')

@section('title')
Import Barang
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div
        class="relative flex flex-col min-w-0 p-6 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="mb-6 font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
          <h6>Import Barang</h6>
        </div>
        <div class="flex-auto ">
          <form action="{{ route('admin.barang.import_excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label class="mb-2 ml-1 font-sans text-sm text-slate-700">Pilih file excel</label>
              <input type="file" class="font-sans text-sm text-slate-700" name="file" required="required">
              @error('excel')
              <span id="FileHelp" class="font-sans text-sm text-slate-700 invalid-feedback" role="alert">
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
