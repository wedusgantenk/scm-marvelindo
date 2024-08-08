@extends('layouts.index')

@section('title', 'Sales')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sales</h5>
                    <!-- Tombol Tambah Data -->
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahDataModal">Tambah Data</button>
                    <!-- Modal Tambah Data -->
                    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tambahDataModalLabel">Form Tambah Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="salesForm">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="id_depo" class="form-label">Depo</label>
                                            <select class="form-select" id="id_depo" name="id_depo" required>
                                                <option value="">--Pilih--</option>
                                                @foreach ($depo as $dp)
                                                <option value="{{ $dp->id }}">{{ $dp->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="area" class="form-label">Area</label>
                                            <input type="text" class="form-control" id="area" name="area" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status" name="status" class="form-select" required>
                                                <option value="">--Pilih--</option>
                                                <option value="aktif">Aktif</option>
                                                <option value="non-aktif">Non-Aktif</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success" id="simpanDataBtn">Simpan</button>
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
                    <table class="table datatable" id="salesTable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Depo</th>
                                <th>Area</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $d)
                            <tr data-id="{{ $d['id'] }}">
                                <td class="editable" data-field="nama">{{ $d['nama'] }}</td>
                                <td class="editable" data-field="email">{{ $d['email'] }}</td>
                                <td class="editable" data-field="id_depo" data-depo-id="{{ $d->depo->id ?? '' }}">{{ $d->depo->nama ?? 'NA'}}</td>
                                <td class="editable" data-field="area">{{ $d['area'] ?? '' }}</td>
                                <td class="editable" data-field="status">{{ $d['status'] ?? '' }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm editBtn" data-id="{{ $d['id'] }}">Edit</button>
                                    <button class="btn btn-sm btn-success saveBtn" style="display:none;">Simpan</button>
                                    <button class="btn btn-sm btn-danger cancelBtn" style="display:none;">Batal</button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $d['id'] }}" data-bs-toggle="modal" data-bs-target="#konfirmasiHapusModal">Hapus</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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

        $('#simpanDataBtn').on('click', function() {
            $('#salesForm').submit();
        });

        $('#salesForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("admin.sales.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    showAlert('Data berhasil ditambahkan', 'success');
                    $('#tambahDataModal').modal('hide');
                    $('#salesForm')[0].reset();
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'Gagal menambahkan data: ';
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + ' ';
                        });
                        showAlert(errorMessage, 'danger');
                    } else if (xhr.status === 500) {
                        showAlert('Terjadi kesalahan server. Silakan coba lagi nanti.', 'danger');
                    } else {
                        showAlert('Gagal menambahkan data', 'danger');
                    }
                }
            });
        });

        $('#salesTable').on('click', '.editBtn', function() {
            var row = $(this).closest('tr');
            row.find('.editable').each(function() {
                var field = $(this).data('field');
                var value = $(this).text();
                if (field === 'status') {
                    var selectHtml = '<select class="form-select"><option value="aktif" ' + (value === 'aktif' ? 'selected' : '') + '>Aktif</option><option value="non-aktif" ' + (value === 'non-aktif' ? 'selected' : '') + '>Non-Aktif</option></select>';
                    $(this).html(selectHtml);
                } else if (field === 'id_depo') {
                    var depoId = $(this).data('depo-id');
                    var selectHtml = '<select class="form-select">';
                    @foreach ($depo as $dp)
                        selectHtml += '<option value="{{ $dp->id }}" ' + (depoId == {{ $dp->id }} ? 'selected' : '') + '>{{ $dp->nama }}</option>';
                    @endforeach
                    selectHtml += '</select>';
                    $(this).html(selectHtml);
                } else {
                    $(this).html('<input type="text" class="form-control" value="' + value + '">');
                }
            });
            row.find('.editBtn').hide();
            row.find('.saveBtn, .cancelBtn').show();

            originalData[row.data('id')] = {};
            row.find('.editable').each(function() {
                var field = $(this).data('field');
                originalData[row.data('id')][field] = $(this).find('input, select').val();
            });
        });

        $('#salesTable').on('click', '.saveBtn', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');
            var data = {};

            row.find('.editable').each(function() {
                var field = $(this).data('field');
                data[field] = $(this).find('input, select').val();
            });

            $.ajax({
                url: '{{ route("admin.sales.update", "") }}/' + id,
                method: 'PUT',
                data: {
                    ...data,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    showAlert('Data berhasil diperbarui', 'success');
                    row.find('.editable').each(function() {
                        var field = $(this).data('field');
                        if (field === 'id_depo') {
                            $(this).text($(this).find('select option:selected').text());
                            $(this).data('depo-id', data[field]);
                        } else {
                            $(this).text(data[field]);
                        }
                    });
                    row.find('.saveBtn, .cancelBtn').hide();
                    row.find('.editBtn').show();
                    delete originalData[id];
                },
                error: function(xhr) {
                    if (xhr.status === 500) {
                        showAlert('Terjadi kesalahan server. Silakan coba lagi nanti.', 'danger');
                    } else {
                        showAlert('Gagal memperbarui data', 'danger');
                    }
                }
            });
        });

        $('#salesTable').on('click', '.cancelBtn', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');

            if (originalData[id]) {
                row.find('.editable').each(function() {
                    var field = $(this).data('field');
                    if (field === 'id_depo') {
                        $(this).text($(this).find('select option:selected').text());
                    } else {
                        $(this).text(originalData[id][field]);
                    }
                });
                delete originalData[id];
            }

            row.find('.saveBtn, .cancelBtn').hide();
            row.find('.editBtn').show();
        });

        $('#salesTable').on('click', '.deleteBtn', function() {
            rowToDelete = $(this).closest('tr');
        });

        $('#konfirmasiHapusBtn').on('click', function() {
            var id = rowToDelete.data('id');
            $.ajax({
                url: '{{ route("admin.sales.delete", "") }}/' + id,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    showAlert('Data berhasil dihapus', 'success');
                    rowToDelete.remove();
                    $('#konfirmasiHapusModal').modal('hide');
                },
                error: function(xhr) {
                    if (xhr.status === 500) {
                        showAlert('Terjadi kesalahan server. Silakan coba lagi nanti.', 'danger');
                    } else {
                        showAlert('Gagal menghapus data', 'danger');
                    }
                }
            });
        });
    });
</script>
@endpush
