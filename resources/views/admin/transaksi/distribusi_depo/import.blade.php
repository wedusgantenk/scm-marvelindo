@extends('layouts.index')

@section('title')
    Distribusi ke Depo
@endsection

@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border p-6">
                    <div class="border-b-0 border-b-solid rounded-t-2xl border-b-transparent font-semibold">
                        <h6 class="text-s font-bold">Distribusi ke Depo</h6>
                    </div>
                    <div class="pb-6 pr-6 pl-6 flex-auto">

                        <form action="{{ route('admin.transaksi.distribusi_depo.import_excel') }}" method="POST"
                            enctype="multipart/form-data" role="form">
                            @csrf
                            <div class="mb-4">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Pilih Cluster</label>
                                <select
                                    class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12"
                                    name="cluster_id" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($cluster as $cl)
                                        <option value="{{ $cl->id }}">{{ $cl->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Pilih Depo</label>
                                <select
                                    class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12"
                                    name="depo_id" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($depo as $dp)
                                        <option value="{{ $dp->id }}">{{ $dp->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="mb-2 ml-1 font-bold text-xs text-slate-700">Pilih File Excel</label>
                                <input type="file"
                                    class="flex-auto focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-red-300 focus:outline-none focus:transition-shadow max-w-full min-w-12"
                                    name="file" required>
                                @error('excel')
                                    <span id="cluster-addon" class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit"
                                    class="inline-block px-6 py-3 mt-6 mb-6 text-xs font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer min-w-12 bg-slate-700 text-csite shadow-soft-md bg-x-25 bg-150 leading-pro ease-soft-in tracking-tight-soft bg-gradient-to-tl from-pink-800 to-red-500 hover:scale-102 hover:shadow-soft-xs active:opacity-85">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
