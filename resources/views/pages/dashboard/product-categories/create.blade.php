<x-layouts.app-layout>
  <x-slot:styles>
    <style>
      .small-box .icon i.fas.fa-tshirt {
        font-size: 70px;
        top: 20px;
      }
    </style>
  </x-slot:styles>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tambah Data Jenis Produk</h3>
        </div>
        <!-- /.card-header -->
        <form method="post" action="{{ route('productCategories.store') }}" class="mt-3">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <div class="form-group">
                <label>Nama Jenis Produk:</label>
                <input type="text" name="nama_kategori" class="form-control @error('nama_kategori')is-invalid @enderror"
                  value="{{ old('nama_kategori') }}">
                @error('nama_kategori')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            <input type="submit" class="btn btn-success" value="Tambah Data">
            <a href="{{ route('productCategories.index') }}" class="btn btn-primary">Kembali</a>
          </div>

        </form>

      </div>
    </div>
  </section>
  </x-layout.app-layout>