@extends('layouts.index')

@section('title', 'Harga Barang')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Harga Barang</h5>                    
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-1"></i>
                        Klik pada nilai harga di tabel untuk mengubahnya.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            
                    <!-- Table with row editing -->
                    <div class="table-responsive">
                        <table id="tbl_room" class="table table-bordered table-hover"></table>
                    </div>
                    <!-- End Table with row editing -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('link')
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
    $.ajax({
        url: "{{ route('admin.harga_barang.fetch') }}",
        method: 'GET',
        success: function(response) {
            try {
                var data = typeof response === 'string' ? JSON.parse(response) : response;

                // Inisialisasi array kolom
                var columns = [];

                data.columns.forEach(function(col) {
                    if (col.title !== "Nama Barang") {
                        columns.push({
                            title: col.title,
                            field: col.field,
                            class: 'col-md-1 center',
                            formatter: formatMoney,
                            editable: col.editable
                        });
                    } else {
                        // Memastikan "Nama Barang" adalah kolom pertama
                        columns.unshift({
                            title: col.title,
                            field: col.field,
                            class: 'col-md-2 center',
                            editable: false // Tidak bisa diedit
                        });
                    }
                });

                // Inisialisasi tabel dengan kolom yang sudah disiapkan
                $('#tbl_room').bootstrapTable({
                    columns: columns,
                    data: data.data,
                    search: true, // Mengaktifkan fitur pencarian
                    searchAlign: 'left', // Menyelaraskan kotak pencarian ke kiri
                    searchPlaceholder: 'Cari berdasarkan Nama Barang atau Harga', // Placeholder untuk kotak pencarian
                    trimOnSearch: true // Memotong spasi pada pencarian
                });

                function formatMoney(value) {
                    var numberValue = parseFloat(value);
                    if (isNaN(numberValue)) {
                        return 'Rp 0';
                    }
                    return 'Rp ' + numberValue.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }

                $('#tbl_room').on('click-cell.bs.table', function (e, field, value, row, $el) {
                    if (field === 'nama_barang' || $(e.target).is('input')) return;  // Mencegah "Nama Barang" dari diedit

                    // Menyimpan nilai asli untuk kasus pembatalan edit
                    var originalValue = value;

                    // Flag untuk memeriksa apakah Enter ditekan untuk konfirmasi edit
                    var confirmed = false;

                    var $input = $('<input>', {
                        type: 'text',
                        value: value,
                        class: 'form-control',
                        keyup: function(event) {
                            if (event.key === 'Enter') {
                                confirmed = true;
                                $(this).blur(); // Trigger blur untuk menyimpan perubahan
                            } else if (event.key === 'Escape') {
                                // Jika tombol Escape ditekan, batalkan edit
                                confirmed = false;
                                $(this).blur();
                            }
                        },
                        blur: function() {
                            if (confirmed) {
                                var newValue = $(this).val();
                                // Jika nilainya tidak berubah, tidak perlu melanjutkan
                                if (newValue === originalValue) {
                                    $el.html(formatMoney(originalValue));
                                    return;
                                }

                                var index = $(this).closest('tr').data('index');
                                var updatedData = $('#tbl_room').bootstrapTable('getData')[index];

                                updatedData[field] = newValue;
                                $('#tbl_room').bootstrapTable('updateRow', {
                                    index: index,
                                    row: updatedData
                                });

                                var prices = {};
                                data.columns.forEach(function(col) {
                                    if (col.editable) {
                                        prices[col.title] = updatedData[col.field] || 0;
                                    }
                                });

                                $.ajax({
                                    url: "{{ route('admin.harga_barang.update') }}",
                                    method: 'POST',
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        nama_barang: updatedData.nama_barang,
                                        prices: prices
                                    },
                                    success: function(response) {
                                        try {
                                            var result = typeof response === 'string' ? JSON.parse(response) : response;
                                            if (result.status === 'success') {
                                                Swal.fire({
                                                    position: 'center',
                                                    icon: 'success',
                                                    title: 'Berhasil',
                                                    showConfirmButton: false,
                                                    timer: 2000
                                                });
                                                // Update tampilan sel dengan nilai yang diformat
                                                $el.html(formatMoney(newValue));
                                                $('#tbl_room').bootstrapTable('load', data.data); // Reload data to prevent duplication
                                            } else {
                                                Swal.fire({
                                                    position: 'center',
                                                    icon: 'error',
                                                    title: 'Terjadi kesalahan',
                                                    text: result.message,
                                                    showConfirmButton: true
                                                });
                                                // Kembalikan ke nilai asli
                                                updatedData[field] = originalValue;
                                                $('#tbl_room').bootstrapTable('updateRow', {
                                                    index: index,
                                                    row: updatedData
                                                });
                                                $el.html(formatMoney(originalValue));
                                            }
                                        } catch (e) {
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'error',
                                                title: 'Terjadi kesalahan parsing',
                                                showConfirmButton: true
                                            });
                                            // Kembalikan ke nilai asli
                                            updatedData[field] = originalValue;
                                            $('#tbl_room').bootstrapTable('updateRow', {
                                                index: index,
                                                row: updatedData
                                            });
                                            $el.html(formatMoney(originalValue));
                                        }
                                    },
                                    error: function() {
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'error',
                                            title: 'Terjadi kesalahan',
                                            showConfirmButton: true
                                        });
                                        // Kembalikan ke nilai asli
                                        updatedData[field] = originalValue;
                                        $('#tbl_room').bootstrapTable('updateRow', {
                                            index: index,
                                            row: updatedData
                                        });
                                        $el.html(formatMoney(originalValue));
                                    }
                                });
                            } else {
                                // Edit dibatalkan, kembalikan ke nilai asli
                                $el.html(formatMoney(originalValue));
                            }
                        }
                    }).appendTo($el.empty()).focus().select();
                });
            } catch (e) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    text: e.message,
                    showConfirmButton: true
                });
            }
        },
        error: function() {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Terjadi kesalahan',
                showConfirmButton: true
            });
        }
    });
});

</script>

@endpush
