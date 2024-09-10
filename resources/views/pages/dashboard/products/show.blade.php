<x-layouts.app-layout>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Produk</h3>

          <div class="card-tools">
            <a href="{{route('forecasts', $product)}}" class="btn btn-primary btn-sm">Jalankan Prediksi</a>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-sm table-borderless">
                <tr>
                  <th>Nama Produk</th>
                  <th>:</th>
                  <td>{{ $product->nama_produk }}</td>
                </tr>
                <tr>
                  <th>Kode Produk</th>
                  <th>:</th>
                  <td>{{ $product->kode_produk }}</td>
                </tr>
                <tr>
                  <th>Kategori Produk</th>
                  <th>:</th>
                  <td>{{ $product->productCategory->nama_kategori }}</td>
                </tr>
                <tr>
                  <th>Warna</th>
                  <th>:</th>
                  <td>{{ $product->warna }}</td>
                </tr>
                <tr>
                  <th>Variasi</th>
                  <th>:</th>
                  <td>{{ $product->variasi }}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Penjualan</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="dataTable" class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Periode</th>
                <th>Penjualan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @if(!$product->sales->isEmpty())
              @foreach($product->sales as $sale)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sale->periode_penjualan }}</td>
                <td>{{ number_format($sale->jumlah_penjualan) }}</td>
                <td>
                  <button class="btn btn-danger btn-sm ml-1 delete-btn" onclick="confirmDelete(this)"
                    data-delete-url="{{ route('sales.destroy', $sale) }}">
                    Hapus
                  </button>

                  <a href="{{ route('sales.edit', $sale)}}" class="btn btn-warning btn-sm">Ubah</a>
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
      </div>
    </div>
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
          text: 'Apakah Anda yakin ingin menghapus data ini?',
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
                    'Data  telah dihapus.',
                    'success'
                  ).then(() => {
                    window.location.reload();
                  });
                } else {
                  Swal.fire(
                    'Error!',
                    'Gagal menghapus data .',
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