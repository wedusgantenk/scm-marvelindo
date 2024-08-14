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
                                            <label for="detail_barang_id" class="form-label">ICCID</label>
                                            <select class="form-select" id="detail_barang_id" name="detail_barang_id" required>
                                                <option value="">--Pilih--</option>
                                                @foreach ($detail_barang as $db)
                                                <option value="{{ $db->id }}">{{ $db->kode_unik }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Tipe</label>
                                            <input type="text" class="form-control" id="type" name="type" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="lokasi_asal_id" class="form-label">Asal</label>
                                            <select class="form-select" id="lokasi_asal_id" name="lokasi_asal_id" required>
                                                <option value="">--Pilih--</option>
                                                @foreach ($cluster as $c)
                                                <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                                @endforeach
                                                @foreach ($depo as $d)
                                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="lokasi_tujuan_id" class="form-label">Tujuan</label>
                                            <select class="form-select" id="lokasi_tujuan_id" name="lokasi_tujuan_id" required>
                                                <option value="">--Pilih--</option>
                                                @foreach ($cluster as $c)
                                                <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                                @endforeach
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
                                <td class="editable" data-field="detail_barang_id" data-detail-barang-id="{{ $histori['detail_barang']['id'] ?? '' }}">{{ $histori['detail_barang']['kode_unik'] ?? 'TIDAK DITEMUKAN DATA' }}</td>
                                <td class="editable" data-field="type">{{ $histori['type'] }}</td>
                                <td class="editable" data-field="lokasi_asal_id" data-lokasi-asal-id="{{ $histori['lokasi_asal']['id'] ?? '' }}">{{ $histori['lokasi_asal']['nama'] ?? 'TIDAK DITEMUKAN DATA' }}</td>
                                <td class="editable" data-field="lokasi_tujuan_id" data-lokasi-tujuan-id="{{ $histori['lokasi_tujuan']['id'] ?? '' }}">{{ $histori['lokasi_tujuan']['nama'] ?? 'TIDAK DITEMUKAN DATA' }}</td>
                                <td class="editable" data-field="tanggal">{{ $histori['tanggal'] }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                                    <button class="btn btn-sm btn-success save-btn" style="display:none;">Simpan</button>
                                    <button class="btn btn-sm btn-danger cancel-btn" style="display:none;">Batal</button>
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

        $('#historiBarangTable').on('click', '.edit-btn', function() {
            var row = $(this).closest('tr');
            row.find('.editable').each(function() {
                var field = $(this).data('field');
                var currentText = $(this).text();
                var currentId = $(this).data(field.replace('_id', '-id'));

                if (field === 'detail_barang_id' || field === 'lokasi_asal_id' || field === 'lokasi_tujuan_id') {
                    var selectHtml = '<select class="form-select editing-select" data-field="' + field + '">';
                    selectHtml += '<option value="">--Pilih--</option>';
                    if (field === 'detail_barang_id') {
                        @foreach ($detail_barang as $db)
                            selectHtml += '<option value="{{ $db->id }}" ' + (currentId == {{ $db->id }} ? 'selected' : '') + '>{{ $db->kode_unik }}</option>';
                        @endforeach
                    } else {
                        @foreach ($cluster as $c)
                            selectHtml += '<option value="{{ $c->id }}" ' + (currentId == {{ $c->id }} ? 'selected' : '') + '>{{ $c->nama }}</option>';
                        @endforeach
                        @foreach ($depo as $d)
                            selectHtml += '<option value="{{ $d->id }}" ' + (currentId == {{ $d->id }} ? 'selected' : '') + '>{{ $d->nama }}</option>';
                        @endforeach
                    }
                    selectHtml += '</select>';
                    $(this).html(selectHtml);
                } else if (field === 'tanggal') {
                    $(this).html('<input type="date" class="form-control editing-input" value="' + currentText + '">');
                } else {
                    $(this).attr('contenteditable', true);
                }
                $(this).addClass('editing');
            });
            row.find('.edit-btn').hide();
            row.find('.save-btn, .cancel-btn').show();

            originalData[row.data('id')] = {};
            row.find('.editable').each(function() {
                var field = $(this).data('field');
                originalData[row.data('id')][field] = $(this).text();
            });
        });

        $('#historiBarangTable').on('click', '.save-btn', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');
            var data = {};

            row.find('.editable').each(function() {
                var field = $(this).data('field');
                var value;
                if ($(this).find('select').length) {
                    value = $(this).find('select').val();
                    var selectedText = $(this).find('select option:selected').text();
                    $(this).text(selectedText);
                } else if ($(this).find('input[type="date"]').length) {
                    value = $(this).find('input[type="date"]').val();
                    $(this).text(value);
                } else {
                    value = $(this).text();
                }
                data[field] = value;
            });

            $.ajax({
                url: '{{ route("admin.histori_barang.update", "") }}/' + id,
                method: 'POST',
                data: {
                    ...data,
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT'
                },
                success: function(response) {
                    showAlert('Data berhasil diperbarui', 'success');
                    row.find('.editable').attr('contenteditable', false).removeClass('editing');
                    row.find('.save-btn, .cancel-btn').hide();
                    row.find('.edit-btn').show();
                    delete originalData[id];
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    showAlert('Gagal memperbarui data: ' + xhr.responseText, 'danger');
                }
            });
        });

        $('#historiBarangTable').on('click', '.cancel-btn', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');

            if (originalData[id]) {
                row.find('.editable').each(function() {
                    var field = $(this).data('field');
                    $(this).text(originalData[id][field]);
                });
                delete originalData[id];
            }

            row.find('.editable').attr('contenteditable', false).removeClass('editing');
            row.find('.save-btn, .cancel-btn').hide();
            row.find('.edit-btn').show();
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
