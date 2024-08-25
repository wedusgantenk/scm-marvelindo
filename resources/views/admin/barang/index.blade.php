@extends('layouts.index')

@section('title')
Barang
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Barang</h5>
                    @notDepo
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
                            Tambah
                        </button>
                        {{-- <a href="{{ route('admin.barang.import') }}" class="btn btn-success">Import Barang</a> --}}
                        <a href="{{ route('admin.barang.export') }}" class="btn btn-info">Export Barang</a>
                    </div>
                    @endnotDepo
                    <!-- Alert untuk notifikasi -->
                    <div id="alertContainer"></div>

                    <table class="table datatable" id="barangTable">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Nama</th>
                                <th>Jenis Barang</th>
                                <th>Gambar</th>
                                <th>Keterangan</th>
                                @notDepo
                                <th>Aksi</th>
                                @endnotDepo
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $d)
                            <tr data-id="{{ $d['id'] }}">
                                <td>{{ $loop->iteration }}</td>
                                <td class="editable" data-field="nama">{{ $d['nama'] }}</td>
                                <td class="editable" data-field="id_jenis">
                                    <span class="jenis-text">{{ $d->jenis_barang->nama ?? 'Tidak Ada' }}</span>
                                    <select class="form-select jenis-select" style="display: none;">
                                        @foreach($jenis_barang as $jenis)
                                            <option value="{{ $jenis->id }}" {{ $d->id_jenis == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="editable" data-field="gambar">
                                    <img src="{{ $d['gambar'] ? asset('images/barang/'.$d['gambar']) : asset('assets/img/no_image.jpg') }}" alt="{{ $d['nama'] }}" class="img-thumbnail" style="max-width: 100px;">
                                    <input type="file" class="form-control gambar-input" style="display: none;">
                                </td>
                                <td class="editable" data-field="keterangan">
                                    {{ Str::limit($d['keterangan'], 50) }}
                                </td>
                                @notDepo
                                <td>
                                    <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                                    <button class="btn btn-sm btn-success save-btn" style="display:none;">Simpan</button>
                                    <button class="btn btn-sm btn-danger cancel-btn" style="display:none;">Batal</button>
                                    <button class="btn btn-sm btn-danger hapus-btn" data-bs-toggle="modal" data-bs-target="#konfirmasiHapusModal">Hapus</button>
                                </td>
                                @endnotDepo
                            </tr>
                            
                            @empty
                            <tr>
                                @notDepo
                                <td colspan="6" class="text-center">Tidak ada data</td>
                                @endnotDepo
                                @depo
                                <td colspan="5" class="text-center">Tidak ada data</td>
                                @enddepo
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @notDepo
    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="tambahBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahBarangModalLabel">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="tambahBarangForm" action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_jenis" class="form-label">Jenis Barang</label>
                            <select class="form-select" id="id_jenis" name="id_jenis" required>
                                <option value="">Pilih Jenis Barang</option>
                                @foreach($jenis_barang as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fisik" class="form-label">Fisik</label>
                            <select class="form-select" id="fisik" name="fisik" required>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="tambahBarangForm" class="btn btn-primary">Simpan</button>
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
    @endnotDepo

</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var originalData = {};
        var rowToDelete;

        function showAlert(message, type) {
            var alertElement = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                                    message +
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>');
            $('#alertContainer').html(alertElement);
            setTimeout(function() {
                alertElement.alert('close');
            }, 3000);
        }

        @notDepo
        $('#barangTable').on('click', '.edit-btn', function() {
            var row = $(this).closest('tr');
            row.find('.editable').attr('contenteditable', true).addClass('editing');
            row.find('.edit-btn').hide();
            row.find('.save-btn, .cancel-btn').show();
            row.find('.gambar-input').show();
            row.find('.jenis-text').hide();
            row.find('.jenis-select').show();

            originalData[row.data('id')] = {};
            row.find('.editable').each(function() {
                var field = $(this).data('field');
                originalData[row.data('id')][field] = $(this).html();
            });
        });

        $('#barangTable').on('click', '.save-btn', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');
            var formData = new FormData();

            row.find('.editable').each(function() {
                var field = $(this).data('field');
                if (field === 'gambar') {
                    var file = row.find('.gambar-input')[0].files[0];
                    if (file) {
                        formData.append('gambar', file);
                    }
                } else if (field === 'id_jenis') {
                    formData.append(field, row.find('.jenis-select').val());
                } else {
                    formData.append(field, $(this).text());
                }
            });

            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'PUT');

            $.ajax({
                url: '{{ route("admin.barang.update", "") }}/' + id,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    showAlert('Data berhasil diperbarui', 'success');
                    row.find('.editable').attr('contenteditable', false).removeClass('editing');
                    row.find('.save-btn, .cancel-btn').hide();
                    row.find('.edit-btn').show();
                    row.find('.gambar-input').hide();
                    row.find('.jenis-text').text(row.find('.jenis-select option:selected').text()).show();
                    row.find('.jenis-select').hide();
                    if (response.gambar) {
                        row.find('img').attr('src', response.gambar);
                    }
                    delete originalData[id];
                },
                error: function(xhr) {
                    if (xhr.status === 405) {
                        showAlert('Metode tidak diizinkan. Pastikan rute dan metode permintaan sudah benar.', 'danger');
                    } else {
                        showAlert('Gagal memperbarui data: ' + xhr.responseText, 'danger');
                    }
                }
            });
        });

        $('#barangTable').on('click', '.cancel-btn', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');

            if (originalData[id]) {
                row.find('.editable').each(function() {
                    var field = $(this).data('field');
                    $(this).html(originalData[id][field]);
                });
                delete originalData[id];
            }

            row.find('.editable').attr('contenteditable', false).removeClass('editing');
            row.find('.save-btn, .cancel-btn').hide();
            row.find('.edit-btn').show();
            row.find('.gambar-input').hide();
            row.find('.jenis-text').show();
            row.find('.jenis-select').hide();
        });

        $('#barangTable').on('click', '.hapus-btn', function() {
            rowToDelete = $(this).closest('tr');
        });

        $('#konfirmasiHapusBtn').on('click', function() {
            var id = rowToDelete.data('id');
            $.ajax({
                url: '{{ route("admin.barang.delete", "") }}/' + id,
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
                    if (xhr.status === 405) {
                        showAlert('Metode tidak diizinkan. Pastikan rute dan metode permintaan sudah benar.', 'danger');
                    } else {
                        showAlert('Gagal menghapus data: ' + xhr.responseText, 'danger');
                    }
                    $('#konfirmasiHapusModal').modal('hide');
                }
            });
        });
        @endnotDepo
    });
</script>
@endpush
