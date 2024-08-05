@extends('layouts.index')

@section('title')
Daftar Barang Masuk
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap ">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 p-6 mb-6 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Barang Masuk</h6>
                </div>
                <div class="flex flex-auto py-4">
                    <div class="flex mr-2">
                        <button class="px-2 py-1 mt-2 text-xs font-semibold text-white rounded-lg bg-gradient-to-tr from-red-500 to-red-900 hover:scale-102 drop-shadow-xl">
                            <a href="{{ route('admin.brg_masuk.import') }}">
                                Import Barang <i class="pl-2 fa fa-upload"></i></a></button>
                    </div>
                    <div class="flex m2-2">
                        <button class="px-2 py-1 mt-2 text-xs font-semibold text-white rounded-lg bg-gradient-to-tl from-red-500 to-red-900 hover:scale-102 drop-shadow-xl">
                            <a href="{{ route('admin.brg_masuk.export') }}">
                                Export Barang <i class="pl-2 fa fa-download"></i></a></button>
                    </div>
                </div>
                <div class="flex-auto pb-2">
                    <div class="overflow-x-auto">
                        <table class="table max-w-full overflow-auto table-flush text-slate-800" id="datatables">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="text-xs font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none border-b-solid tracking-none whitespace-nowrap">Nomor</th>
                                    <th class="text-xs font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none border-b-solid tracking-none whitespace-nowrap">Tanggal</th>
                                    <th class="text-xs font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none border-b-solid tracking-none whitespace-nowrap">Kode Cluster</th>
                                    <th class="text-xs font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none border-b-solid tracking-none whitespace-nowrap">Nama Barang</th>
                                    <th class="text-xs font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none border-b-solid tracking-none whitespace-nowrap">Nomor DO</th>
                                    <th class="text-xs font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none border-b-solid tracking-none whitespace-nowrap">Nomor PO</th>
                                    <th class="text-xs font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none border-b-solid tracking-none whitespace-nowrap">Petugas</th>
                                    {{-- <th class="text-xs font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none border-b-solid tracking-none whitespace-nowrap">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody class="px-6 py-3 text-sm font-semibold text-left border-spacing-4">
                                @forelse ($data as $d)
                                <tr>
                                    <td> {{ $loop->iteration }}. </td>
                                    <td> {{ AppHelper::instance()->convertDate($d['tanggal']) }} </td>
                                    <td> {{ $d->kode_cluster ?? 'N/A' }} </td>
                                    <td> {{ $d->barang->nama }} </td>
                                    <td> {{ $d->no_do }} </td>
                                    <td> {{ $d->no_po }} </td>
                                    <td> {{ $d->petugas->username }} </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="6" class="text-center">Tidak ada data</th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
