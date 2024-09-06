<x-layouts.app-layout>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Produk</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

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
                <td>...</td>
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
    </script>
  </x-slot:script>
</x-layouts.app-layout>