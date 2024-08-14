@extends('layouts.index')

@section('title', 'Daftar Barang Masuk')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Barang Masuk</h5>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahDataModal">Import
                            Data</button>

                        <!-- Modal Tambah Data -->
                        <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahDataModalLabel">Import Data Barang Masuk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="barangMasukForm" action="{{ route('admin.barang_masuk.import_excel') }}"
                                            method="POST" enctype="multipart/form-data" role="form">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Pilih File Excel</label>
                                                <input type="file" class="form-control" id="file" name="file"
                                                    accept=".xlsx" required>
                                            </div>
                                            <div class="mb-3 text-muted">
                                                <p>Untuk mempermudah pengisian data, gunakan template Excel berikut:</p>
                                                <a href="{{ asset('template/barang_masuk.xlsx') }}" class="btn btn-outline-success" download>
                                                    <div class="icon" style="display: flex; align-items: center;">
                                                        <i class="ri-file-excel-2-line" style=" font-size: 1.2rem;"></i>
                                                        <span style="margin-left: 0.5rem; ">Download Template Excel</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-primary" id="simpanDataBtn">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alert untuk hasil pengeditan -->
                        <div id="editAlert" class="alert" style="display: none;" role="alert"></div>

                        <!-- Table with row editing -->
                        <table class="table datatable table-striped" id="datatables">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Kode Cluster</th>
                                <th>Nama Barang</th>
                                <th>Nomor DO</th>
                                <th>Nomor PO</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $d)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($d['tanggal'])->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                <td class="text-center">{{ $d->kode_cluster ?? 'N/A' }}</td>
                                <td>{{ $d->barang->nama }}</td>
                                <td>{{ $d->no_do }}</td>
                                <td>{{ $d->no_po }}</td>
                                <td>{{ $d->petugas->username }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                        <!-- End Table with row editing -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var originalData = {};

            function showAlert(message, type) {
                var alertElement = $('#editAlert');
                alertElement.removeClass('alert-success alert-danger').addClass('alert-' + type);
                alertElement.text(message);
                alertElement.fadeIn().delay(3000).fadeOut();
            }

            $('#simpanDataBtn').on('click', function() {
                $('#barangMasukForm').submit();
            });

            $('#barangMasukForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData($('#barangMasukForm')[0]);
                $.ajax({
                    url: '{{ route('admin.barang_masuk.import_excel') }}',
                    method: 'POST',
                    data: formData,
                    processData: false, // Tidak mengubah data menjadi query string
                    contentType: false, // Jangan set content-type header
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showAlert(response.message, 'success');
                            $('#tambahDataModal').modal('hide');
                            $('#barangMasukForm')[0].reset();
                        } else {
                            showAlert(response.message, 'danger');
                            $('#tambahDataModal').modal('hide');
                            $('#barangMasukForm')[0].reset();
                        }
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr) {
                        showAlert('Gagal menambahkan data', 'danger');
                        $('#tambahDataModal').modal('hide');
                        $('#barangMasukForm')[0].reset();
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                });
            });

            // Handle delete button click
            $('#barangMasukTable').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this item?')) {
                    $.ajax({
                        url: '{{ route('admin.barang_masuk.delete') }}',
                        method: 'POST',
                        data: {
                            id: id,
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                showAlert(response.message, 'success');
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                showAlert(response.message, 'danger');
                            }
                        },
                        error: function(xhr) {
                            showAlert('Gagal menghapus data', 'danger');
                        }
                    });
                }
            });
        });
    </script>
@endpush
