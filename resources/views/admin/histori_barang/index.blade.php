@extends('layouts.index')

@section('title')
Histori Barang
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Histori Barang</h5>

                    <!-- Alert untuk notifikasi -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Tombol Tambah Data -->
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahHistoriBarangModal">Tambah Histori Barang</button>

                    <!-- Modal Tambah Data -->
                    <div class="modal fade" id="tambahHistoriBarangModal" tabindex="-1" aria-labelledby="tambahHistoriBarangModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tambahHistoriBarangModalLabel">Form Tambah Histori Barang</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="historiBarangForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="id_detail_barang" class="form-label">ICCID</label>
                                            <select class="form-select" id="id_detail_barang" name="id_detail_barang" required>
                                                <option value="">--Pilih--</option>
                                                @foreach ($detail_barang as $db)
                                                <option value="{{ $db->id }}">{{ $db->kode_unik }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Tipe</label>
                                            <select class="form-select" id="type" name="type" required>
                                                <option value="">Pilih Tipe</option>
                                                <option value="depo">Depo</option>
                                                <option value="cluster">Cluster</option>
                                                <option value="sales">Sales</option>
                                                <option value="outlet">Outlet</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="lokasi_asal_id" class="form-label">Asal</label>
                                            <select class="form-select" id="lokasi_asal_id" name="id_lokasi_asal" required>
                                                <option value="">--Pilih--</option>
                                                @foreach ($cluster as $c)
                                                <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="id_lokasi_tujuan" class="form-label">Tujuan</label>
                                            <select class="form-select" id="id_lokasi_tujuan" name="id_lokasi_tujuan" required>
                                                <option value="">--Pilih--</option>
                                                @foreach ($depo as $d)
                                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal" class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success" id="simpanHistoriBarangBtn">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-danger" id="konfirmasiHapusBtn">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alert untuk hasil pengeditan -->
                    <div id="editAlert" class="alert" style="display: none;" role="alert"></div>

                    <!-- Table with row editing -->
                    <table class="table datatable" id="historiBarangTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ICCID</th>
                                <th>Tipe</th>
                                <th>Asal</th>
                                <th>Tujuan</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $histori)
                            <tr data-id="{{ $histori['id'] }}">
                                <td>{{ $index + 1 }}</td>
                                <td class="editable" data-field="id_detail_barang" data-detail-barang-id="{{ $histori['detail_barang']['id'] ?? '' }}">{{ $histori['detail_barang']['kode_unik'] ?? 'TIDAK DITEMUKAN DATA' }}</td>
                                <td class="editable" data-field="type">{{ $histori['type'] }}</td>
                                <td class="editable" data-field="lokasi_asal_id" data-lokasi-asal-id="{{ $histori['lokasi_asal']['id'] ?? '' }}">{{ $histori['lokasi_asal']['nama'] ?? 'TIDAK DITEMUKAN DATA' }}</td>
                                <td class="editable" data-field="id_lokasi_tujuan" data-lokasi-tujuan-id="{{ $histori['lokasi_tujuan']['id'] ?? '' }}">{{ $histori['lokasi_tujuan']['nama'] ?? 'TIDAK DITEMUKAN DATA' }}</td>
                                <td class="editable" data-field="tanggal">{{ \Carbon\Carbon::parse($histori['tanggal'])->format('d F Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger hapus-btn" data-bs-toggle="modal" data-bs-target="#konfirmasiHapusModal">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
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
        var rowToDelete;

        function showAlert(message, type) {
            var alertElement = $('#editAlert');
            alertElement.removeClass('alert-success alert-danger').addClass('alert-' + type);
            alertElement.text(message);
            alertElement.fadeIn().delay(3000).fadeOut();
        }

        $('#simpanHistoriBarangBtn').on('click', function() {
            $('#historiBarangForm').submit();
        });

        $('#historiBarangForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("admin.histori_barang.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    showAlert('Data berhasil ditambahkan', 'success');
                    $('#tambahHistoriBarangModal').modal('hide');
                    $('#historiBarangForm')[0].reset();
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    showAlert('Gagal menambahkan data: ' + xhr.responseText, 'danger');
                }
            });
        });

        $('#historiBarangTable').on('click', '.hapus-btn', function() {
            rowToDelete = $(this).closest('tr');
        });

        $('#konfirmasiHapusBtn').on('click', function() {
            var id = rowToDelete.data('id');
            $.ajax({
                url: '{{ route("admin.histori_barang.delete", "") }}/' + id,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    showAlert('Data berhasil dihapus', 'success');
                    rowToDelete.remove();
                    $('#konfirmasiHapusModal').modal('hide');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    showAlert('Gagal menghapus data: ' + xhr.responseText, 'danger');
                }
            });
        });
    });
</script>
@endpush
