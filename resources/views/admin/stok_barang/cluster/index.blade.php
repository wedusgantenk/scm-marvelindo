@extends('layouts.index')

@section('title')
Stok Barang Cluster
@endsection

@section('content')

<div class="w-full max-w-full">
  <div class="relative flex flex-col min-w-0 p-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
      <h6>Stok Barang Cluster</h6>
    </div>
    <div class="flex flex-auto py-2 col-md-4">
      <button class="px-2 py-1 mt-2 text-xs font-semibold text-white rounded-lg bg-gradient-to-tr from-red-500 to-red-900 hover:scale-102 drop-shadow-xl">
        <a href="{{ route('admin.stok_barang.cluster.create')}}">Tambah</a>
    </div>
    <div class="overflow-x-auto table-responsive">
      <table class="table w-full table-flush text-slate-800" id="datatables">
        <thead class="thead-light">
          <tr>
            <th>Cluster</th>
            <th>Stok</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($data as $d)
          <tr>
            <td class="text-sm font-normal leading-normal border-t"> {{ $d->cluster->nama ?? 'N/A'}} </td>
            <td class="text-sm font-normal leading-normal border-t"> {{ $d->stok }} </td>
          </tr>
          @empty
          <tr>
            <th colspan="2" class="text-sm font-normal leading-normal">Tidak ada data</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
