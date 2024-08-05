@extends('layouts.index')

@section('title')
Jenis Barang
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <!-- table 1 -->

    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 p-6 mb-6 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="font-semibold bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Jenis Barang</h6>
                </div>
                <div class="flex flex-auto py-2 col-md-4">
                    <button class="px-2 py-1 mt-2 text-xs font-semibold text-white rounded-lg bg-gradient-to-tr from-red-500 to-red-900 hover:scale-102 drop-shadow-xl">
                        <a href="{{ route('admin.jenis_barang.create')}}">Tambah</a>
                </div>
                <div class="flex-auto pb-2">
                    <div class="overflow-x-auto table-responsive">
                        <table class="table max-w-full overflow-auto table-flush text-slate-800" id="datatables">
                            <thead class="thead-light">
                                <tr>
                                    <th class="w-12">Nomor</th>
                                    <th class="">Nama Jenis Barang</th>
                                    <th class="">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="px-6 py-3 text-xs font-semibold text-left border-spacing-4">
                                @forelse ($data as $d)
                                <tr>
                                    <td class="text-sm font-normal leading-normal border-t"> {{ $loop->iteration }}. </td>
                                    <td class="text-sm font-normal leading-normal border-t"> {{ $d['nama'] }} </td>
                                    <td class="flex space-x-2 text-sm font-normal leading-normal border-t ">
                                        <a href="{{ route('admin.jenis_barang.edit', $d['id']) }}" class="mx-2 btn btn-success btn-xs"><i class="fas fa-edit fa-lg hover:scale-102"></i></a>
                                        <a class="mx-1 btn btn-danger btn-xs">
                                            <form action="{{ route('admin.jenis_barang.delete', $d['id']) }}" method="post" onsubmit="return confirm('Apakah yakin ingin menghapus jenis barang {{ $d['nama'] }} ?')">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" name="submit"><i class="fas fa-trash-alt fa-lg hover:scale-102"></i></button>
                                            </form>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="3" class="p-2 text-center bg-transparent border-b whitespace-nowrap shadow-transparent">Tidak ada data</th>
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
