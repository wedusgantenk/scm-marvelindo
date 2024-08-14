@extends('layouts.index')

@section('title')
Distribusi ke Depo
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#tambahDataModal">Tambah Data</button>
                    <button class="btn btn-info my-3" data-bs-toggle="modal" data-bs-target="#importDataModal">Import Data</button>

                    
                    <!-- Modal Import Data -->
                <div class="modal fade" id="importDataModal" tabindex="-1" aria-labelledby="importDataModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importDataModalLabel">Import Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.transaksi_distribusi_depo.import_excel') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="id_cluster" class="form-label">Pilih Cluster</label>
                                        <select class="form-select" id="id_cluster" name="id_cluster" required>
                                            @foreach(App\Models\Cluster::all() as $cluster)
                                                <option value="{{ $cluster->id }}">{{ $cluster->nama }}</option>
                                            @endforeach
                                        </select>

                                        <label for="id_depo" class="form-label">Pilih Depo</label>
                                        <select class="form-select" id="id_depo" name="id_depo" required>
                                            @foreach(App\Models\Depo::all() as $depo)
                                                <option value="{{ $depo->id }}">{{ $depo->nama }}</option>
                                            @endforeach
                                        </select>

                                        <select class="form-select" id="id_petugas" name="id_petugas" required hidden>
                                            @php
                                                // Ambil informasi petugas yang sedang login
                                                $petugas = Auth::user();
                                            @endphp
                                            <option value="{{ $petugas->id }}" selected>
                                                {{ $petugas->id }} - {{ $petugas->username }}
                                            </option>
                                        </select>

                                        <!-- Input untuk tanggal dengan nilai default tanggal saat ini -->
                                        <input type="date" id="tanggal" name="tanggal" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" hidden>

                                        <!-- Input untuk status dengan nilai string kosong -->
                                        <input type="hidden" id="status" name="status" value="-" hidden>

                                        <label for="file" class="form-label">Choose Excel File</label>
                                        <input type="file" class="form-control" id="file" name="file" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- Modal Tambah Data -->
                    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tambahDataModalLabel">Form Tambah Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.transaksi_distribusi_depo.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="id_petugas" class="form-label">Nama Petugas</label>
                                            <select class="form-select" id="id_petugas" name="id_petugas" required>
                                                @foreach(App\Models\Petugas::all() as $petugas)
                                                    <option value="{{ $petugas->id }}">{{ $petugas->username }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="id_cluster" class="form-label">Nama Cluster</label>
                                            <select class="form-select" id="id_cluster" name="id_cluster" required>
                                                @foreach(App\Models\Cluster::all() as $cluster)
                                                    <option value="{{ $cluster->id }}">{{ $cluster->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="id_depo" class="form-label">Nama Depo</label>
                                            <select class="form-select" id="id_depo" name="id_depo" required>
                                                @foreach(App\Models\Depo::all() as $depo)
                                                    <option value="{{ $depo->id }}">{{ $depo->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="tanggal" class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <input type="text" class="form-control" id="status" name="status" required>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <!-- Modal Edit Data -->
                    @foreach($transaksiDistribusiDepos as $d)
                    <div class="modal fade" id="editDataModal{{ $d->id }}" tabindex="-1" aria-labelledby="editDataModalLabel{{ $d->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editDataModalLabel{{ $d->id }}">Form Edit Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.transaksi_distribusi_depo.update', $d->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="edit_id_petugas{{ $d->id }}" class="form-label">Nama Petugas</label>
                                            <select class="form-select" id="edit_id_petugas{{ $d->id }}" name="id_petugas" required>
                                                @foreach(App\Models\Petugas::all() as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ $petugas->id == $d->id_petugas ? 'selected' : '' }}>{{ $petugas->username }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_id_cluster{{ $d->id }}" class="form-label">Nama Cluster</label>
                                            <select class="form-select" id="edit_id_cluster{{ $d->id }}" name="id_cluster" required>
                                                @foreach(App\Models\Cluster::all() as $cluster)
                                                    <option value="{{ $cluster->id }}" {{ $cluster->id == $d->id_cluster ? 'selected' : '' }}>{{ $cluster->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_id_depo{{ $d->id }}" class="form-label">Nama Depo</label>
                                            <select class="form-select" id="edit_id_depo{{ $d->id }}" name="id_depo" required>
                                                @foreach(App\Models\Depo::all() as $depo)
                                                    <option value="{{ $depo->id }}" {{ $depo->id == $d->id_depo ? 'selected' : '' }}>{{ $depo->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_tanggal{{ $d->id }}" class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" id="edit_tanggal{{ $d->id }}" name="tanggal" value="{{ $d->formatted_tanggal }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_status{{ $d->id }}" class="form-label">Status</label>
                                            <input type="text" class="form-control" id="edit_status{{ $d->id }}" name="status" value="{{ $d->status }}" required>
                                        </div>

                                        <button type="submit" class="btn btn-success">Perbarui</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach --}}

                    <!-- Modal Konfirmasi Hapus Data -->
                    <div class="modal fade" id="konfirmasiHapusModal" tabindex="-1" aria-labelledby="konfirmasiHapusModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="konfirmasiHapusModalLabel">Konfirmasi Hapus Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus data ini?
                                </div>
                                <div class="modal-footer">
                                    <form id="deleteForm" method="POST" action="">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <!-- Alert untuk hasil operasi -->
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Tabel dengan data -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Petugas</th>
                                <th>Cluster</th>
                                <th>Depo</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksiDistribusiDepos as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->petugas->username }}</td>
                                <td>{{ $d->cluster->nama }}</td>
                                <td>{{ $d->depo->nama }}</td>
                                <td>{{ $d->tanggal }}</td>
                                <td>{{ $d->status }}</td>
                                <td>
                                     <!-- Tombol Lihat -->
                                    <a class="btn btn-sm btn-info" href="{{ route('admin.transaksi_distribusi_depo.show', ['id' => $d->id]) }}">Lihat</a>

                                    {{-- <a class="btn btn-sm btn-primary" href="#editDataModal{{ $d->id }}" data-bs-toggle="modal">Edit</a> --}}
                                    <!-- Tombol Hapus -->
                                    <a type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#konfirmasiHapusModal" data-id="{{ $d->id }}">Hapus</a>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteForms = document.querySelectorAll('.btn-danger[data-bs-toggle="modal"]');
        deleteForms.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = btn.getAttribute('data-id');
                var form = document.getElementById('deleteForm');
                form.action = '/transaksi/distribusi_depo/' + id;
            });
        });
    });
</script>

@endsection
