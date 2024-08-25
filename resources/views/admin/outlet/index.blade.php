@extends('layouts.index')

@section('title')
Outlet
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Outlet</h5>
                    <!-- Tombol Tambah Data -->
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahOutletModal">Tambah Outlet</button>

                    <!-- Modal Tambah Data -->
                    <div class="modal fade" id="tambahOutletModal" tabindex="-1" aria-labelledby="tambahOutletModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tambahOutletModalLabel">Form Tambah Outlet</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="outletForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama Outlet</label>
                                            <input type="text" class="form-control" id="nama" name="nama" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="bts_id" class="form-label">BTS</label>
                                            <select class="form-select" id="bts_id" name="bts_id" required>
                                                <option value="">--Pilih--</option>
                                                @foreach ($bts as $bt)
                                                <option value="{{ $bt->id }}">{{ $bt->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jenis_id" class="form-label">Jenis Outlet</label>
                                            <select class="form-select" id="jenis_id" name="jenis_id" required>
                                                <option value="">--Pilih--</option>
                                                @foreach ($jenisOutlet as $jo)
                                                <option value="{{ $jo->id }}">{{ $jo->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @notDepo
                                        <div class="mb-3">
                                            <label for="depo_id" class="form-label">Depo</label>
                                            <select class="form-select" id="depo_id" name="depo_id" required>
                                                <option value="">--Pilih--</option>
                                                @foreach ($depo as $dp)
                                                <option value="{{ $dp->id }}">{{ $dp->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endnotDepo
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success" id="simpanOutletBtn">Simpan</button>
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
                    <table class="table datatable" id="outletTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>BTS</th>
                                <th>Jenis Outlet</th>
                                <th>Depo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $outlet)
                            <tr data-id="{{ $outlet->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td class="editable" data-field="nama">{{ $outlet->nama }}</td>
                                <td class="editable" data-field="bts_id" data-bts-id="{{ $outlet->bts->id ?? '' }}">{{ $outlet->bts->nama ?? 'N/A' }}</td>
                                <td class="editable" data-field="jenis_id" data-jenis-id="{{ $outlet->jenisOutlet->id ?? '' }}">{{ $outlet->jenisOutlet->nama ?? 'N/A' }}</td>
                                @notDepo
                                <td class="editable" data-field="depo_id" data-depo-id="{{ $outlet->depo->id ?? '' }}">{{ $outlet->depo->nama ?? 'N/A' }}</td>
                                @endnotDepo
                                @depo
                                <td>{{ $outlet->depo->nama ?? 'N/A' }}</td>
                                @enddepo
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

        $('#simpanOutletBtn').on('click', function() {
            $('#outletForm').submit();
        });

        $('#outletForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("admin.outlet.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    showAlert('Data berhasil ditambahkan', 'success');
                    $('#tambahOutletModal').modal('hide');
                    $('#outletForm')[0].reset();
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    showAlert('Gagal menambahkan data: ' + xhr.responseText, 'danger');
                }
            });
        });

        $('#outletTable').on('click', '.edit-btn', function() {
            var row = $(this).closest('tr');
            originalData[row.data('id')] = {};
            
            row.find('.editable').each(function() {
                var field = $(this).data('field');
                originalData[row.data('id')][field] = $(this).text();                                                         
            });
            
            row.find('.editable').each(function() {
                var field = $(this).data('field');
                var currentText = $(this).text();
                var currentId = $(this).data(field.replace('_id', '-id'));
                

                @notDepo
                if (field === 'bts_id' || field === 'jenis_id' || field === 'depo_id') {
                    var selectHtml = '<select class="form-select editing-select" data-field="' + field + '">';
                    selectHtml += '<option value="">--Pilih--</option>';

                    if (field === 'bts_id') {
                        @foreach ($bts as $bt)
                            selectHtml += '<option value="{{ $bt->id }}" ' + (currentId == {{ $bt->id }} ? 'selected' : '') + '>{{ $bt->nama }}</option>';
                        @endforeach
                    } else if (field === 'jenis_id') {
                        @foreach ($jenisOutlet as $jo)
                            selectHtml += '<option value="{{ $jo->id }}" ' + (currentId == {{ $jo->id }} ? 'selected' : '') + '>{{ $jo->nama }}</option>';
                        @endforeach
                    } else if (field === 'depo_id') {
                        @foreach ($depo as $dp)
                            selectHtml += '<option value="{{ $dp->id }}" ' + (currentId == {{ $dp->id }} ? 'selected' : '') + '>{{ $dp->nama }}</option>';
                        @endforeach
                    }

                    selectHtml += '</select>';
                    $(this).html(selectHtml);
                } else {
                    $(this).attr('contenteditable', true);
                }
                @endnotDepo

                @depo
                if (field === 'bts_id' || field === 'jenis_id') {
                    var selectHtml = '<select class="form-select editing-select" data-field="' + field + '">';
                    selectHtml += '<option value="">--Pilih--</option>';

                    if (field === 'bts_id') {
                        @foreach ($bts as $bt)
                            selectHtml += '<option value="{{ $bt->id }}" ' + (currentId == {{ $bt->id }} ? 'selected' : '') + '>{{ $bt->nama }}</option>';
                        @endforeach
                    } else if (field === 'jenis_id') {
                        @foreach ($jenisOutlet as $jo)
                            selectHtml += '<option value="{{ $jo->id }}" ' + (currentId == {{ $jo->id }} ? 'selected' : '') + '>{{ $jo->nama }}</option>';
                        @endforeach
                    }

                    selectHtml += '</select>';
                    $(this).html(selectHtml);
                } else {
                    $(this).attr('contenteditable', true);
                }
                @enddepo
                $(this).addClass('editing');
            });
            row.find('.edit-btn').hide();
            row.find('.save-btn, .cancel-btn').show();            
        });

        $('#outletTable').on('click', '.save-btn', function() {
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
                url: '{{ route("admin.outlet.update", "") }}/' + id,
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

        $('#outletTable').on('click', '.cancel-btn', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');
            
            console.log('Cancel clicked for id:', id);
            console.log('Original Data:', originalData[id]);            

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

        $('#outletTable').on('click', '.hapus-btn', function() {
            rowToDelete = $(this).closest('tr');
        });

        $('#konfirmasiHapusBtn').on('click', function() {
            var id = rowToDelete.data('id');
            $.ajax({
                url: '{{ route("admin.outlet.delete", "") }}/' + id,
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
