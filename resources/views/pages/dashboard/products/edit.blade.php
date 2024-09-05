<x-layouts.app-layout>
  <x-slot:styles>
    <style>
      .small-box .icon i.fas.fa-tshirt {
        font-size: 70px;
        top: 20px;
      }

      .error-message {
        color: red;
        font-size: 0.9em;
        display: none;
      }
    </style>
  </x-slot:styles>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Ubah Data Produk</h3>
        </div>
        <!-- /.card-header -->
        <form method="post" action="{{ route('products.update', $product )}}" class="mt-3">
          @method('PATCH')
          @csrf
          <div class="card-body">
            <div class="form-group">
              <div class="form-group">
                <label for="kode_produk">Kode Produk:</label>
                <input type="text" name="kode_produk" class="form-control @error('kode_produk') is-invalid @enderror"
                  value="{{ $product->kode_produk ?? old('kode_produk') }}" id="kode_produk">
                @error('kode_produk')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <div class="form-group">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror"
                  value="{{ $product->nama_produk ?? old('nama_produk') }}" id="nama_produk">
                @error('nama_produk')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <div class="form-group">
                <label>Warna:</label>
                <input type="text" name="warna" class="form-control @error('warna') is-invalid @enderror"
                  value="{{ $product->warna ?? old('warna')}}">
                @error('warna')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <div class="form-group">
                <label>Variasi:</label>
                <input type="text" name="variasi" class="form-control @error('variasi') is-invalid @enderror"
                  value="{{ $product->variasi ?? old('variasi') }}" id="variasi">
                @error('variasi')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <label for="">Jenis Produk:</label>
              <select name="product_category_id"
                class="form-control @error('product_category_id') is-invalid @enderror">
                <option value="">Pilih terlebih dahulu</option>
                @foreach($productCategories as $category)
                <option value="{{ $category->id }}" {{ old('product_category_id')==$category->id ? 'selected' :
                  ($product->product_category_id == $category->id ? 'selected' : '') }}>
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
            <input type="submit" value="Ubah" class="btn btn-success">
            <a href="{{ route('products.index') }}" class="btn btn-primary">Kembali</a>
          </div>
          <!-- /.card-body -->
        </form>
        <!-- /.card -->
      </div>
    </div>
  </section>
</x-layouts.app-layout>