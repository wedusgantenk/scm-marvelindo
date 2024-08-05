@extends('layouts.index')

@section('title')
Depo
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Depo</h5>
                    <!-- Tombol Tambah Data -->
                    <button class="btn btn-primary mb-3" id="tambahDataBtn">Tambah Data</button>
                    <!-- Form Tambah Data -->
                    <div id="formTambahData" style="display: none;">
                        <h5>Form Tambah Data</h5>
                        <form id="depoForm">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_cluster" class="form-label">Cluster</label>
                                <select class="form-control" id="id_cluster" name="id_cluster" required>
                                    @foreach($clusters as $cluster)
                                        <option value="{{ $cluster['id']}}">{{ $cluster['nama'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-secondary" id="batalTambahBtn">Batal</button>
                        </form>
                    </div>
                    <!-- Alert untuk hasil pengeditan -->
                    <div id="editAlert" class="alert" style="display: none;" role="alert"></div>
                    <!-- Table with row editing -->
                    <table class="table datatable" id="depoTable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Cluster</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $d)
                            <tr data-id="{{ $d['id'] }}">
                                <td class="editable" data-field="nama">{{ $d['nama'] }}</td>
                                <td class="editable" data-field="id_cluster" data-cluster-id="{{ $d['id_cluster'] }}">
                                    {{ $d->cluster ? $d->cluster->nama : 'Tidak ada cluster' }}
                                </td>
                                <td class="editable" data-field="alamat">{{ $d['alamat'] }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn">Edit</button>
                                    <button class="btn btn-sm btn-success save-btn" style="display:none;">Simpan</button>
                                    <button class="btn btn-sm btn-danger cancel-btn" style="display:none;">Batal</button>
                                    <button class="btn btn-sm btn-danger hapus-btn">Hapus</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data</td>
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

        $('#tambahDataBtn').on('click', function() {
            $('#formTambahData').show();
        });

        $('#batalTambahBtn').on('click', function() {
            $('#formTambahData').hide();
            $('#depoForm')[0].reset();
        });

        $('#depoForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("admin.depo.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    showAlert('Data berhasil ditambahkan', 'success');
                    $('#formTambahData').hide();
                    $('#depoForm')[0].reset();
                    location.reload();
                },
                error: function(xhr) {
                    showAlert('Gagal menambahkan data', 'danger');
                }
            });
        });

        $('#depoTable').on('click', '.edit-btn', function() {
            var row = $(this).closest('tr');
            row.find('.editable').attr('contenteditable', true).addClass('editing');
            row.find('.edit-btn').hide();
            row.find('.save-btn, .cancel-btn').show();

            originalData[row.data('id')] = {};
            row.find('.editable').each(function() {
                var field = $(this).data('field');
                originalData[row.data('id')][field] = $(this).text();
            });

            var clusterCell = row.find('[data-field="id_cluster"]');
            var clusterId = clusterCell.data('cluster-id');
            var clusterOptions = @json($clusters);
            var select = $('<select class="form-control"></select>');
            clusterOptions.forEach(function(cluster) {
                var option = $('<option></option>').val(cluster.id).text(cluster.nama);
                if (cluster.id == clusterId) {
                    option.attr('selected', 'selected');
                }
                select.append(option);
            });
            clusterCell.html(select);
        });

        $('#depoTable').on('click', '.save-btn', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');
            var data = {};

            row.find('.editable').each(function() {
                var field = $(this).data('field');
                var value = $(this).text();
                if (field === 'id_cluster') {
                    value = $(this).find('select').val();
                }
                data[field] = value;
            });

            $.ajax({
                url: '/admin/depo/' + id,
                method: 'PUT',
                data: {
                    ...data,
                    _token: '{{ csrf_token() }}'
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

        $('#depoTable').on('click', '.cancel-btn', function() {
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

        $('#depoTable').on('click', '.hapus-btn', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: '/admin/depo/' + id,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        showAlert('Data berhasil dihapus', 'success');
                        row.remove();
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
