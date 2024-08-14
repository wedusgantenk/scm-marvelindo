@extends('layouts.index')

@section('title')
Barang
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <!-- table 1 -->

    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 p-6 mb-6 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Barang</h6>
                </div>                
                <div class="flex-auto pb-2">
                    <div class="overflow-x-auto">
                        <table class="items-center w-full px-6 py-3 mb-0 align-top border-transparent border-gray-200 table-auto text-slate-600" id="datatables">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="w-12 border-t">Nomor</th>
                                    <th class="border-t">Nama</th>
                                    <th class="border-t">Gambar</th>
                                    <th class="border-t">Keterangan</th>
                                    <th class="border-t">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="px-6 py-3 text-xs font-semibold text-left border-t border-spacing-4">
                                @forelse ($data as $d)
                                <tr>
                                    <td class="text-sm font-normal leading-normal border-t">
                                        {{ $loop->iteration }}.
                                    </td>
                                    <td class="text-sm font-normal leading-normal border-t">
                                        {{ $d['nama'] }}
                                    </td>
                                    <td class="text-sm font-normal leading-normal border">
                                        @if($d['gambar'])
                                        <img src="{{ asset('storage/images/barang/' . $d['gambar']) }}" alt="Gambar {{ $d['nama'] }}" class="object-cover w-16 h-16">
                                        @else
                                        Tidak ada gambar
                                        @endif
                                    </td>
                                    <td class="text-sm font-normal leading-normal border-t">
                                        {{ substr($d['keterangan'], 0, 50) }}
                                        {{ strlen($d['keterangan']) > 50 ? '...' : '' }}
                                    </td>

                                    <td class="flex text-sm font-normal leading-normal border-t">
                                        {{-- <a href="{{ route('admin.barang.edit', $d['id']) }}" class="flex btn btn-success btn-xs"><i class="m-2 fas fa-edit fa-lg hover:scale-102"></i></a>
                                        <a class="flex btn btn-danger btn-xs">
                                            <form action="{{ route('admin.barang.delete', $d['id']) }}" method="post" onsubmit="return confirm('Apakah yakin ingin menghapus barang {{ $d['nama'] }} ?')">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" name="submit"><i class="flex m-2 fas fa-trash-alt fa-lg hover:scale-102"></i></button>
                                            </form>
                                        </a> --}}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="5" class="p-2 text-center bg-transparent whitespace-nowrap shadow-transparent">
                                        Tidak ada data</th class="border-t">
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
