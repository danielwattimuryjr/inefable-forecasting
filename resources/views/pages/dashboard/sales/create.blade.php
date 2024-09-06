<x-layouts.app-layout>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tambah Data Penjualan</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form action="{{ route('sales.store') }}" method="post">
            @csrf
            <div class="form-group">
              <div class="form-group">
                <label for="kode_produk">Produk:</label>
                <select name="product_id" class="form-control @error('product_id') is-invalid @enderror">
                  <option selected disabled>-- PILIH PRODUK --</option>
                  @foreach($products as $product)
                  <option value="{{ $product->id}}" {{ old('product_id')==$product->id ? 'selected' : '' }}>
                    {{ $product->kode_produk }} - {{ $product->nama_produk}}
                  </option>
                  @endforeach
                </select>
                @error('product_id')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="periode_penjualan">Periode Penjualan</label>
                <input type="date" id="periode_penjualan" name="periode_penjualan"
                  class="form-control @error('periode_penjualan') is-invalid @enderror"
                  value="{{ old('periode_penjualan') }}">
                @error('periode_penjualan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="kode_produk">Jumlah Penjualan</label>
                <input type="number" name="jumlah_penjualan"
                  class="form-control @error('jumlah_penjualan') is-invalid @enderror"
                  value="{{ old('jumlah_penjualan') }}" min="0">
                @error('jumlah_penjualan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <input type="submit" value="Tambah" class="btn btn-success">
              <a href="{{ route('sales.index') }}" class="btn btn-primary">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</x-layouts.app-layout>