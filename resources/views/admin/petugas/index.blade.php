@extends('layouts.index')

@section('title', 'Petugas')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Petugas</h5>
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahDataModal">Tambah Data</button>
                    <!-- Modal Tambah Data -->
                    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data Petugas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="petugasForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Hak Akses</label>
                                            <select class="form-select" id="role" name="role" required>
                                                <option value="">--Pilih--</option>
                                                <option value="admin">Admin</option>
                                                <option value="cluster">Cluster</option>
                                                <option value="depo">Depo</option>
                                            </select>
                                        </div>
                                        <div class="mb-3" id="bagianField" style="display: none;">
                                            <label for="bagian" class="form-label">Bagian</label>
                                            <select class="form-select" id="bagian" name="bagian">
                                                <option value="">--Pilih Bagian--</option>
                                                <option value="gudang">Gudang</option>
                                                <option value="keuangan">Keuangan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3" id="clusterField" style="display: none;">
                                            <label for="cluster_id" class="form-label">Cluster</label>
                                            <select class="form-select" id="cluster_id" name="cluster_id">
                                                <option value="">--Pilih Cluster--</option>
                                                @foreach ($cluster as $c)
                                                    <option value="{{ $c['id'] }}">{{ $c['nama'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3" id="depoField" style="display: none;">
                                            <label for="depo_id" class="form-label">Depo</label>
                                            <select class="form-select" id="depo_id" name="depo_id">
                                                <option value="">--Pilih Depo--</option>
                                                @foreach ($depo as $d)
                                                    <option value="{{ $d['id'] }}">{{ $d['nama'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-primary" id="simpanDataBtn">Simpan</button>
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
                    <table class="table datatable" id="petugasTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Hak Akses</th>
                                <th>Jenis</th>
                                <th>Bagian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $d)
                            <tr data-id="{{ $d['id'] }}">
                                <td>{{ $index + 1 }}</td>
                                <td class="editable" data-field="username">{{ $d['username'] }}</td>
                                <td class="editable" data-field="hak_akses">
                                    <select class="form-select edit-select" style="display: none;">
                                        <option value="admin" {{ $d['hak_akses'] == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="cluster" {{ $d['hak_akses'] == 'cluster' ? 'selected' : '' }}>Cluster</option>
                                        <option value="depo" {{ $d['hak_akses'] == 'depo' ? 'selected' : '' }}>Depo</option>
                                    </select>
                                    <span class="edit-text">{{ $d['hak_akses'] }}</span>
                                </td>
                                <td class="editable" data-field="jenis">
                                    <select class="form-select edit-select" style="display: none;">
                                        <option value="0">-</option>
                                        @if($d['hak_akses'] == 'cluster')
                                            @foreach ($cluster as $c)
                                                <option value="{{ $c['id'] }}" {{ $d['jenis'] == $c['id'] ? 'selected' : '' }}>{{ $c['nama'] }}</option>
                                            @endforeach
                                        @elseif($d['hak_akses'] == 'depo')
                                            @foreach ($depo as $dp)
                                                <option value="{{ $dp['id'] }}" {{ $d['jenis'] == $dp['id'] ? 'selected' : '' }}>{{ $dp['nama'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="edit-text">
                                        @if($d['hak_akses'] == 'cluster')
                                            {{ $cluster->firstWhere('id', $d['jenis'])['nama'] ?? '-' }}
                                        @elseif($d['hak_akses'] == 'depo')
                                            {{ $depo->firstWhere('id', $d['jenis'])['nama'] ?? '-' }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </td>
                                <td class="editable" data-field="bagian">
                                    <select class="form-select edit-select" style="display: none;">
                                        <option value="0" {{ $d['bagian'] == 0 ? 'selected' : '' }}>-</option>
                                        <option value="gudang" {{ $d['bagian'] == 'gudang' ? 'selected' : '' }}>Gudang</option>
                                        <option value="keuangan" {{ $d['bagian'] == 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                                    </select>
                                    <span class="edit-text">{{ $d['bagian'] == 0 ? '-' : $d['bagian'] }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                                    <button class="btn btn-sm btn-success save-btn" style="display:none;">Simpan</button>
                                    <button class="btn btn-sm btn-danger cancel-btn" style="display:none;">Batal</button>
                                    <button class="btn btn-sm btn-danger hapus-btn" data-bs-toggle="modal" data-bs-target="#konfirmasiHapusModal">Hapus</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">- data</td>
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
        var rowToDelete;

        function showAlert(message, type) {
            var alertElement = $('#editAlert');
            alertElement.removeClass('alert-success alert-danger').addClass('alert-' + type);
            alertElement.text(message);
            alertElement.fadeIn().delay(3000).fadeOut();
        }

        $('#role').change(function() {
            var selectedRole = $(this).val();
            $('#bagianField, #clusterField, #depoField').hide();
            $('#bagian, #cluster_id, #depo_id').val('');

            if (selectedRole === 'admin') {
                $('#bagianField').show();
            } else if (selectedRole === 'cluster') {
                $('#clusterField').show();
            } else if (selectedRole === 'depo') {
                $('#depoField').show();
            }
        });

        $('#simpanDataBtn').on('click', function() {
            $('#petugasForm').submit();
        });

        $('#petugasForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("admin.petugas.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    showAlert('Data berhasil ditambahkan', 'success');
                    $('#tambahDataModal').modal('hide');
                    $('#petugasForm')[0].reset();
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    var errorMessage = 'Terjadi kesalahan saat menambahkan data. Silakan coba lagi.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showAlert(errorMessage, 'danger');
                }
            });
        });

        $('#petugasTable').on('click', '.edit-btn', function() {
            var row = $(this).closest('tr');
            var hakAkses = row.find('[data-field="hak_akses"] .edit-select').val();

            row.find('.editable').each(function() {
                $(this).find('.edit-text').hide();
                $(this).find('.edit-select').show();
            });

            if (hakAkses === 'admin') {
                row.find('[data-field="jenis"] .edit-select').hide();
                row.find('[data-field="jenis"] .edit-text').show();
            } else if (hakAkses === 'cluster' || hakAkses === 'depo') {
                row.find('[data-field="bagian"] .edit-select').hide();
                row.find('[data-field="bagian"] .edit-text').show();
            }

            row.find('.edit-btn').hide();
            row.find('.save-btn, .cancel-btn').show();

            originalData[row.data('id')] = {};
            row.find('.editable').each(function() {
                var field = $(this).data('field');
                originalData[row.data('id')][field] = $(this).find('.edit-select').val() || $(this).find('.edit-text').text();
            });
        });

        $('#petugasTable').on('change', '[data-field="hak_akses"] .edit-select', function() {
            var row = $(this).closest('tr');
            var hakAkses = $(this).val();
            var jenisSelect = row.find('[data-field="jenis"] .edit-select');
            var bagianSelect = row.find('[data-field="bagian"] .edit-select');

            if (hakAkses === 'admin') {
                jenisSelect.hide();
                row.find('[data-field="jenis"] .edit-text').show();
                bagianSelect.show();
                row.find('[data-field="bagian"] .edit-text').hide();
            } else if (hakAkses === 'cluster') {
                jenisSelect.empty().append('<option value="">--Pilih Cluster--</option>');
                @foreach ($cluster as $c)
                    jenisSelect.append('<option value="{{ $c['id'] }}">{{ $c['nama'] }}</option>');
                @endforeach
                jenisSelect.show();
                row.find('[data-field="jenis"] .edit-text').hide();
                bagianSelect.hide();
                row.find('[data-field="bagian"] .edit-text').show();
            } else if (hakAkses === 'depo') {
                jenisSelect.empty().append('<option value="">--Pilih Depo--</option>');
                @foreach ($depo as $d)
                    jenisSelect.append('<option value="{{ $d['id'] }}">{{ $d['nama'] }}</option>');
                @endforeach
                jenisSelect.show();
                row.find('[data-field="jenis"] .edit-text').hide();
                bagianSelect.hide();
                row.find('[data-field="bagian"] .edit-text').show();
            }
        });

        $('#petugasTable').on('click', '.save-btn', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');
            var data = {};

            row.find('.editable').each(function() {
                var field = $(this).data('field');
                var value = $(this).text();
                data[field] = value;
            });

            $.ajax({
                url: '{{ route("admin.petugas.update", "") }}/' + id,
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
                    location.reload();
                },
                error: function(xhr) {
                    showAlert('Gagal memperbarui data', 'danger');
                }
            });
        });

        $('#petugasTable').on('click', '.cancel-btn', function() {
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

        $('#petugasTable').on('click', '.hapus-btn', function() {
            rowToDelete = $(this).closest('tr');
        });

        $('#konfirmasiHapusBtn').on('click', function() {
            var id = rowToDelete.data('id');
            $.ajax({
                url: '{{ route("admin.petugas.delete", "") }}/' + id,
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
                    showAlert('Gagal menghapus data', 'danger');
                }
            });
        });
    });
</script>
@endpush
