<x-layouts.app-layout>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Jenis Produk</h3>
                    <div class="card-tools">
                        <a href="{{ route('productCategories.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Tambah Data Jenis Produk
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <p class="mb-4">
                        <i>Note : Jika data jenis produk dihapus maka data produk
                            dan
                            data penjualan akan ikut
                            terhapus</i>
                    </p>
                    <table id="dataTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jenis Produk</th>
                                <th>Jumlah Produk</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$productCategories->isEmpty())
                            @foreach($productCategories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->nama_kategori }}</td>
                                <td>{{ $category->products_count }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm ml-1 delete-btn" onclick="confirmDelete(this)"
                                        data-delete-url="{{ route('productCategories.destroy', $category) }}">
                                        Hapus
                                    </button>

                                    <a href="{{ route('productCategories.edit', $category)}}"
                                        class="btn btn-warning btn-sm">Ubah</a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4">Data masih kosong</td>
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
            function confirmDelete(button) {
                const deleteUrl = $(button).data('delete-url');

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: 'Apakah Anda yakin ingin menghapus jenis produk ini?',
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
                                        'Jenis produk telah dihapus.',
                                        'success'
                                    ).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Gagal menghapus jenis produk.',
                                        'error'
                                    );
                                }
                            },
                            error: function (xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus jenis produk.',
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