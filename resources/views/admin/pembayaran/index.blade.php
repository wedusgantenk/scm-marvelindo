@extends('layouts.index')

@section('title')
Pembayaran
@endsection

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pembayaran</h5>
                    <!-- Alert untuk hasil pengeditan -->
                    <div id="editAlert" class="alert" style="display: none;" role="alert"></div>
                    <!-- Table with row editing -->
                    <table class="table table-striped" id="pembayaranTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Outlet</th>
                                <th>Tanggal</th>
                                <th>Tipe Payment</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Status Pembayaran</th>
                                <th>Bukti Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
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

        $('#pembayaranTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.pembayaran.getData") }}',
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false,
                    searchable: false
                },
                { data: 'nama_outlet', name: 'nama_outlet' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'tipe_payment', name: 'tipe_payment' },
                { data: 'total', name: 'total' },
                { data: 'status', name: 'status' },
                { data: 'status_pembayaran', name: 'status_pembayaran' },
                {
                    data: 'url_bukti',
                    name: 'url_bukti',
                    render: function(data, type, row) {
                        return data ? '<img src="' + data + '" alt="Bukti Pembayaran" style="max-width: 100px; max-height: 100px;">' : '<img src="{{ asset("assets/img/no_image.jpg") }}" alt="Tidak Ada Gambar" style="max-width: 100px; max-height: 100px;">';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button class="btn btn-sm btn-primary edit-btn" data-id="' + row.id + '">Edit</button>';
                    }
                }
            ]
        });

        $('#pembayaranTable').on('click', '.edit-btn', function() {
            var row = $(this).closest('tr');
            var id = $(this).data('id');

            // Simpan data asli
            originalData[id] = {};
            row.find('td').each(function(index) {
                var field = $('#pembayaranTable').DataTable().column(index).dataSrc();
                originalData[id][field] = $(this).text();
            });

            // Ubah sel menjadi input untuk editing hanya untuk kolom status pembayaran
            var statusPembayaranCell = row.find('td:eq(6)');
            var currentValue = statusPembayaranCell.text();
            statusPembayaranCell.html('<select class="form-control editing" data-field="status_pembayaran">' +
                '<option value="dibayar" ' + (currentValue === 'Dibayar' ? 'selected' : '') + '>Dibayar</option>' +
                '<option value="belum bayar" ' + (currentValue === 'Belum Bayar' ? 'selected' : '') + '>Belum Bayar</option>' +
                '</select>');

            // Ganti tombol edit dengan save dan cancel
            $(this).replaceWith('<button class="btn btn-sm btn-success save-btn" data-id="' + id + '">Simpan</button> <button class="btn btn-sm btn-danger cancel-btn">Batal</button>');
        });

        $('#pembayaranTable').on('click', '.save-btn', function() {
            var row = $(this).closest('tr');
            var id = $(this).data('id');
            var data = {};

            row.find('.editing').each(function() {
                var field = $(this).data('field');
                var value = $(this).val();
                data[field] = value;
            });

            $.ajax({
                url: '{{ route("admin.pembayaran.update", ":id") }}'.replace(':id', id),
                method: 'POST',
                data: {
                    ...data,
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT'
                },
                success: function(response) {
                    showAlert('Data berhasil diperbarui', 'success');
                    $('#pembayaranTable').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    showAlert('Gagal memperbarui data: ' + error, 'danger');
                }
            });
        });

        $('#pembayaranTable').on('click', '.cancel-btn', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');

            $('#pembayaranTable').DataTable().ajax.reload();
        });
    });
</script>
@endpush
