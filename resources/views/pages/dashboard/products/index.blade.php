<x-layouts.app-layout>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Produk</h3>
                    <div class="card-tools">
                        <a href="{{ route('products.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Tambah Data Produk
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <p class="mb-4">
                        <i>Note : Jika data produk dihapus maka
                            data penjualan akan ikut
                            terhapus</i>
                    </p>
                    <table id="dataTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Jenis Produk</th>
                                <th>Warna</th>
                                <th>Variasi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$products->isEmpty())
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->kode_produk }}</td>
                                <td>{{ $product->nama_produk }}</td>
                                <td>{{ $product->productCategory->nama_kategori }}</td>
                                <td>{{ $product->warna }}</td>
                                <td>{{ $product->variasi }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm ml-1 delete-btn" onclick="confirmDelete(this)"
                                        data-delete-url="{{ route('products.destroy', $product) }}">
                                        Hapus
                                    </button>

                                    <a href="{{ route('products.edit', $product)}}"
                                        class="btn btn-warning btn-sm">Ubah</a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7">Data masih kosong</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-fluid -->
    </section>

    <x-slot:script>
        <script>
            $(document).ready(function () {
                $('#dataTable').DataTable();
            })

            function confirmDelete(button) {
                const deleteUrl = $(button).data('delete-url');

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: 'Apakah Anda yakin ingin menghapus produk ini?',
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
                                        'Produk telah dihapus.',
                                        'success'
                                    ).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Gagal menghapus produk.',
                                        'error'
                                    );
                                }
                            },
                            error: function (xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus produk.',
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