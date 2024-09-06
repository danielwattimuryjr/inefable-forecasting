<x-layouts.app-layout>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Penjualan</h3>
          <div class="card-tools">
            <a href="{{ route('sales.create') }}" class="btn btn-success">
              <i class="bi bi-plus-circle"></i> Tambah Data Penjualan
            </a>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <p class="mb-4">
            <i>Note : Klik <b>Template</b> untuk mengunduh template excel untuk melakukan import</i>
          </p>
          <p class="mb-4">
            <i>Note : Import Excel harus menggunakan template yang sudah tersedia atau file dari
              export
              excel</i>
          </p>

          <table id="dataTable" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Warna</th>
                <th>Variasi</th>
                <th>Total Penjualan</th>
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
                <td>{{ $product->warna }}</td>
                <td>{{ $product->variasi }}</td>
                <td>{{ number_format($product->sales_sum_jumlah_penjualan) ?? 0 }}</td>
                <td>
                  <a href="{{ route('products.show', $product )}}" class="btn btn-primary btn-sm">Detail</a>
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
          text: 'Apakah Anda yakin ingin menghapus data penjualan ini?',
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
                    'Data penjualan telah dihapus.',
                    'success'
                  ).then(() => {
                    window.location.reload();
                  });
                } else {
                  Swal.fire(
                    'Error!',
                    'Gagal menghapus data penjualan.',
                    'error'
                  );
                }
              },
              error: function (xhr, status, error) {
                Swal.fire(
                  'Error!',
                  'Terjadi kesalahan saat menghapus data penjualan.',
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