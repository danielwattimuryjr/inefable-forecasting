<x-layouts.app-layout>
    <x-slot:style>
        <style>
            #data-penjualan {
                display: none;
            }

            .loading-spinner {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 9999;
            }

            .button-container {
                display: flex;
                justify-content: flex-end;
                margin-bottom: 10px;
            }

            .button-container button {
                margin-left: 5px;
            }
        </style>
    </x-slot:style>

    <div class="content">
        <div class="container-fluid">
            @if (auth()->user()->role == 'direktur_operasional')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Halaman Prediksi Penjualan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('forecasts.show') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="product_category_id">Pilih Kategori Produk</label>
                            <select name="product_category_id" id=""
                                class="form-control @error('product_category_id') 'is-invalid' @enderror">
                                <option selected disabled>-- PILIH KATEGORI PRODUK --</option>
                                @foreach ($productCategories as $category)
                                <option value="{{ $category->id }}" {{ old('product_category_id')==$category->id ?
                                    'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                            @error('product_category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <input type="submit" value="Lakukan Prediksi" class="btn btn-success">
                    </form>

                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Hasil Prediksi</h3>

                    <div class="card-tools">
                        @if (auth()->user()->role != 'admin')
                        <a href="{{route('exports.forecasts')}}" class="btn btn-danger">
                            <i class="bi bi-filetype-pdf"></i>
                        </a>

                        @if (auth()->user()->role == 'direktur_operasional')
                        <button id="delete-all" class="btn btn-warning" onclick="confirmDelete(this)"
                            data-delete-url="{{ route('forecasts.truncate')}}">Hapus Semua</button>
                        @endif
                        @endif
                    </div>

                </div>
                <div class="card-body">
                    <p class="mb-4">
                        <i>Note : Klik icon PDF untuk mencetak hasil prediksi</i>
                    </p>
                    <div class="table-responsive">
                        <table id="prediksi-table" class="table-bordered table-striped table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Ukuran</th>
                                    <th>Periode</th>
                                    <th>Prediksi</th>
                                    <th>Tanggal Prediksi</th>
                                    <th>Vote</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($forecasts as $forecast)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $forecast->product->nama_produk}}</td>
                                    <td>{{ $forecast->product->variasi}}</td>
                                    <td>{{ $forecast->periode}}</td>
                                    <td>{{ $forecast->value}}</td>
                                    <td>{{ $forecast->created_at->toFormattedDateString()}}</td>
                                    <td>{{ $forecast->created_at}}</td>
                                    <td>{{ $forecast->created_at}}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot:script>
        <script>
            $(document).ready(function() {
                var table = $('#prediksi-table').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "columnDefs": [{
                        "targets": 'aksi-col',
                        "orderable": false,
                    }]
                });
            })

            function confirmDelete(button) {
        const deleteUrl = $(button).data('delete-url');

        Swal.fire({
          title: 'Konfirmasi Penghapusan',
          text: 'Apakah kamu yakin?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                    Swal.fire(
                        'Dihapus!',
                        'Data berhasil dihapus',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                    } else {
                    Swal.fire(
                        'Error!',
                        'Gagal menghapus data.',
                        'error'
                    );
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire(
                    'Error!',
                    'Terjadi kesalahan saat menghapus data.',
                    'error'
                    );
                }
                });
            }
            });
        }
        </script>
    </x-slot:script>
</x-layouts.app-layout>