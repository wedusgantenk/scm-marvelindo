@extends('layouts.index')

@section('title')
Detail Barang
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detail Barang</h5>
                    <!-- Tombol Tambah Data -->
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahDetailBarangModal">Tambah Detail Barang</button>

                    <!-- Modal Tambah Data -->
                    <div class="modal fade" id="tambahDetailBarangModal" tabindex="-1" aria-labelledby="tambahDetailBarangModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tambahDetailBarangModalLabel">Form Tambah Detail Barang</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="detailBarangForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="barang_id" class="form-label">Nama Barang</label>
                                            <select class="form-select" id="barang_id" name="barang_id" required>
                                                <option value="">--Pilih--</option>
                                                @foreach ($barang as $b)
                                                <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kode_unik" class="form-label">ICCID</label>
                                            <input type="text" class="form-control" id="kode_unik" name="kode_unik" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="">--Pilih--</option>
                                                <option value="0">Tidak aktif</option>
                                                <option value="1">Aktif</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success" id="simpanDetailBarangBtn">Simpan</button>
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
                    <table class="table datatable" id="detailBarangTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nomor PO</th>
                                <th>ICCID</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $detail)
                            <tr data-id="{{ $detail->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td class="editable" data-field="id_barang" data-barang-id="{{ $detail->id }}">{{ $detail->barang->nama ?? 'Tidak Ada'}}</td>
                                <td>{{ $detail->barang_masuk->no_po ?? 'N/A' }}</td>
                                <td class="editable" data-field="kode_unik">{{ $detail->kode_unik }}</td>
                                <td class="editable" data-field="status" data-status="{{ $detail->status }}">
                                    {{ $detail->status == 0 ? 'Tidak aktif' : ($detail->status == 1 ? 'Aktif' : $detail->status) }}
                                </td>
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

        $('#simpanDetailBarangBtn').on('click', function() {
            $('#detailBarangForm').submit();
        });

        $('#detailBarangForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("admin.detail_barang.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    showAlert('Data berhasil ditambahkan', 'success');
                    $('#tambahDetailBarangModal').modal('hide');
                    $('#detailBarangForm')[0].reset();
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    showAlert('Gagal menambahkan data: ' + xhr.responseText, 'danger');
                }
            });
        });

        $('#detailBarangTable').on('click', '.edit-btn', function() {
            var row = $(this).closest('tr');
            row.find('.editable').each(function() {
                var field = $(this).data('field');
                var currentText = $(this).text();
                var currentId = $(this).data(field.replace('_id', '-id'));

                if (field === 'barang_id') {
                    var selectHtml = '<select class="form-select editing-select" data-field="' + field + '">';
                    selectHtml += '<option value="">--Pilih--</option>';
                    @foreach ($barang as $b)
                        selectHtml += '<option value="{{ $b->id }}" ' + (currentId == {{ $b->id }} ? 'selected' : '') + '>{{ $b->nama }}</option>';
                    @endforeach
                    selectHtml += '</select>';
                    $(this).html(selectHtml);
                } else if (field === 'status') {
                    var selectHtml = '<select class="form-select editing-select" data-field="' + field + '">';
                    selectHtml += '<option value="0" ' + (currentText === 'Tidak aktif' ? 'selected' : '') + '>Tidak aktif</option>';
                    selectHtml += '<option value="1" ' + (currentText === 'Aktif' ? 'selected' : '') + '>Aktif</option>';
                    selectHtml += '</select>';
                    $(this).html(selectHtml);
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

        $('#detailBarangTable').on('click', '.save-btn', function() {
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
                } else {
                    value = $(this).text();
                }
                data[field] = value;
            });

            $.ajax({
                url: '{{ route("admin.detail_barang.update", "") }}/' + id,
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

        $('#detailBarangTable').on('click', '.cancel-btn', function() {
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

        $('#detailBarangTable').on('click', '.hapus-btn', function() {
            rowToDelete = $(this).closest('tr');
        });

        $('#konfirmasiHapusBtn').on('click', function() {
            var id = rowToDelete.data('id');
            $.ajax({
                url: '{{ route("admin.detail_barang.delete", "") }}/' + id,
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
