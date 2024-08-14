@extends('layouts.index')

@section('title')
Barang
@endsection

@section('content')
<div class="w-full px-6 py-6 mx-auto">
    <!-- table 1 -->

    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 p-6 mb-6 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="font-semibold border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6>Barang</h6>
                </div>
                <div class="flex-auto pb-2">
                    <div class="overflow-x-auto">
                        <table class="items-center w-full px-6 py-3 mb-0 align-top border-transparent border-gray-200 table-auto text-slate-600" id="datatables">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="w-12 border-t">Nomor</th>
                                    <th class="border-t">Nama</th>
                                    <th class="border-t">Gambar</th>
                                    <th class="border-t">Keterangan</th>
                                    <th class="border-t">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="px-6 py-3 text-xs font-semibold text-left border-t border-spacing-4">
                                @forelse ($data as $d)
                                <tr>
                                    <td class="text-sm font-normal leading-normal border-t">
                                        {{ $loop->iteration }}.
                                    </td>
                                    <td class="text-sm font-normal leading-normal border-t">
                                        {{ $d['nama'] }}
                                    </td>
                                    <td class="text-sm font-normal leading-normal border">
                                        @if($d['gambar'])
                                        <img src="{{ asset('storage/images/barang/' . $d['gambar']) }}" alt="Gambar {{ $d['nama'] }}" class="object-cover w-16 h-16">
                                        @else
                                        Tidak ada gambar
                                        @endif
                                    </td>
                                    <td class="text-sm font-normal leading-normal border-t">
                                        {{ substr($d['keterangan'], 0, 50) }}
                                        {{ strlen($d['keterangan']) > 50 ? '...' : '' }}
                                    </td>

                                    <td class="flex text-sm font-normal leading-normal border-t">
                                        {{-- <a href="{{ route('admin.barang.edit', $d['id']) }}" class="flex btn btn-success btn-xs"><i class="m-2 fas fa-edit fa-lg hover:scale-102"></i></a>
                                        <a class="flex btn btn-danger btn-xs">
                                            <form action="{{ route('admin.barang.delete', $d['id']) }}" method="post" onsubmit="return confirm('Apakah yakin ingin menghapus barang {{ $d['nama'] }} ?')">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" name="submit"><i class="flex m-2 fas fa-trash-alt fa-lg hover:scale-102"></i></button>
                                            </form>
                                        </a> --}}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="5" class="p-2 text-center bg-transparent whitespace-nowrap shadow-transparent">
                                        Tidak ada data</th class="border-t">
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
    });
</script>
@endpush
