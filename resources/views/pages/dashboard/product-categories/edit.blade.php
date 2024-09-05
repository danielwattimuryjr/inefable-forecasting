<x-layouts.app-layout>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Edit Jenis Produk</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form method="post" action="{{ route('productCategories.update', $productCategory->id) }}" class="mt-3">
                @method('PATCH')
                @csrf
                <div class="form-group">
                  <input type="text" name="nama_kategori"
                    class="form-control @error('nama_kategori')is-invalid @enderror"
                    value="{{ $productCategory->nama_kategori ?? old('nama_kategori') }}">
                  @error('nama_kategori')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <input type="submit" class="btn btn-success" value="Ubah">
                <a href="{{ route('productCategories.index') }}" class="btn btn-primary">Kembali</a>
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
  </section>
</x-layouts.app-layout>