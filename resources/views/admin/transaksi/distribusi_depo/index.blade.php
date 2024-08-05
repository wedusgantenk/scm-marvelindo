@extends('layouts.index')

@section('title')
Distribusi ke Depo
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 p-6 mb-6 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Distribusi ke Depo</h6>
                </div>
                <div class="flex flex-auto py-2 space-x-2">
                    <button class="px-2 py-1 mt-2 text-xs font-semibold text-white rounded-lg bg-gradient-to-tr from-red-500 to-red-900 hover:scale-102 drop-shadow-xl">
                        <a href="{{ route('admin.transaksi.distribusi_depo.create')}}">Tambah</a></button>
                    <button class="px-2 py-1 mt-2 text-xs font-semibold text-white rounded-lg bg-gradient-to-tr from-red-500 to-red-900 hover:scale-102 drop-shadow-xl">
                        <a href="{{ route('admin.transaksi.distribusi_depo.import') }}">
                            Import Data <i class="pl-2 fa fa-upload"></i></a></button>
                </div>
                <div class="flex-auto pb-2">
                    <div class="overflow-x-auto">
                        <table class="table max-w-full overflow-auto table-flush text-slate-800" id="datatables">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="w-12">Nomor</th>
                                    <th class="">Tanggal</th>
                                    <th class="">Cluster</th>
                                    <th class="">Depo</th>
                                    <th class="">Petugas</th>
                                    <th class="">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="px-6 py-3 text-xs font-semibold text-left border-spacing-4">
                                @forelse ($data as $d)
                                <tr>
                                    <td class="text-sm font-normal leading-normal border-t"> {{ $loop->iteration }} </td>
                                    <td class="text-sm font-normal leading-normal border-t"> {{ AppHelper::instance()->convertDate($d['tanggal']) }} </td>
                                    <td class="text-sm font-normal leading-normal border-t"> {{ $d->cluster->nama ?? 'N/A' }} </td>
                                    <td class="text-sm font-normal leading-normal border-t"> {{ $d->depo->nama ?? 'N/A' }} </td>
                                    <td class="text-sm font-normal leading-normal border-t"> {{ $d->petugas->username ?? 'N/A' }} </td>
                                    <td class="flex text-sm font-normal leading-normal border-t">
                                        <a href="{{ route('admin.transaksi.distribusi_depo.detail', $d['id']) }}" class="mx-2 btn btn-success btn-xs"><i class="fa fa-eye fa-lg hover:scale-102"></i></a>
                                        <a href="{{ route('admin.transaksi.distribusi_depo.edit', $d['id']) }}" class="mx-2 btn btn-success btn-xs"><i class="fas fa-edit fa-lg hover:scale-102"></i></a>
                                        <a class="mx-1 btn btn-danger btn-xs">
                                            <form action="{{ route('admin.transaksi.distribusi_depo.delete', $d['id']) }}" method="post" onsubmit="return confirm('Apakah yakin ingin menghapus detail transaksi {{ $d['id'] }} ?')">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" name="submit"><i class="fas fa-trash-alt fa-lg hover:scale-102"></i></button>
                                            </form>
                                        </a>
                                    </td>
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
