@extends('layouts.index')

@section('title')
Edit Sales
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
  <div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
      <div class="relative flex flex-col min-w-0 p-6 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
          <h6>Edit Sales {{ $data['nama'] }}</h6>
        </div>
        <div class="flex-auto ">
          <form action="{{ route('admin.sales.update', $data['id'] ) }}" method="POST" enctype="multipart/form-data" role="form">
            @csrf
            @method('PATCH')
            <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Pilih Depo</label>
            <div class="mb-3">
              <select class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-csite bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-20" name="id_depo" aria-describedby="depoHelp" id="selectDepo" required>
                <option value="">-- Pilih --</option>
                @foreach ($depo as $dp)
                <option value="{{ $dp['id'] }}">{{ $dp['nama'] }}</option>
                @endforeach
              </select>
              @error('id_depo')
              <span id="depoHelp" class="invalid-feedback" role="alert">
                <small>{{ $message }}</small>
              </span>
              @enderror
            </div>
            <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Nama Sales</label>
            <div class="mb-4">
              <input type="text" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-csite bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-20" id="inputSales" placeholder="Masukkan nama Sales" aria-label="sales" aria-describedby="sales-addon" autocomplete="off" value="{{ $data['nama'] }}" name="nama" required>
              @error('nama')
              <span id="sales-addon" class="invalid-feedback" role="alert"></span>
              @enderror
            </div>
            <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Email</label>
            <div class="mb-4">
              <input type="text" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-csite bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-20" id="inputoutlet" placeholder="Masukkan email" aria-label="sales" aria-describedby="sales-addon" autocomplete="off" value="{{ $data['email'] }}" name="email" required>
              @error('email')
              <span id="sales-addon" class="invalid-feedback" role="alert"></span>
              @enderror
            </div>
            <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Area</label>
            <div class="mb-4">
              <input type="text" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-csite bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-20" id="inputArea" placeholder="Masukkan area" aria-label="sales" aria-describedby="sales-addon" autocomplete="off" value="{{ $data['area'] }}" name="area" required>
              @error('area')
              <span id="sales-addon" class="invalid-feedback" role="alert"></span>
              @enderror
            </div>
            <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Password</label>
            <div class="mb-4">
              <input type="password" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-csite bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-20" id="inputPwd" placeholder="Masukkan Password" aria-label="sales" aria-describedby="sales-addon" autocomplete="off" value="{{ $data['password'] }}" name="password" required>
              @error('password')
              <span id="sales-addon" class="invalid-feedback" role="alert"></span>
              @enderror
            </div>
            <label class="mb-2 ml-1 text-xs font-bold text-slate-700">Status</label>
            <div class="mb-4">
              <input type="text" class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-csite bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-20" id="inputStatus" placeholder="Masukkan area" aria-label="sales" aria-describedby="sales-addon" autocomplete="off" value="{{ $data['status'] }}" name="status" required>
              @error('status')
              <span id="sales-addon" class="invalid-feedback" role="alert"></span>
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
