@extends('layouts.index')

@section('title')
Stok Barang Depo
@endsection

@section('content')

<div class="w-full max-w-full">
  <div class="relative flex flex-col min-w-0 p-6 break-words bg-white border-0 shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
      <h6>Stok Barang Depo</h6>
    </div>
    <div class="overflow-x-auto table-responsive">
      <table class="table w-full table-flush text-slate-800" id="datatables">
        <thead class="thead-light">
          <tr>
            <th>Depo</th>
            <th>Stok</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($data as $d)
          <tr>
            <td class="text-sm font-normal leading-normal"> {{ $d->depo->nama ?? 'N/A' }} </td>
            <td class="text-sm font-normal leading-normal"> {{ $d->stok }} </td>
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
