<x-layouts.app-layout>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Ubah Profile</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form action="{{ route('profiles.update') }}" method="post">
            @method('PATCH')
            @csrf
            <div class="form-group">
              <div class="form-group">
                <label for="nama">Nama Pengguna</label>
                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                  value="{{ old('nama') ?? $user->nama }}">
                @error('nama')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                  value="{{ old('username') ?? $user->username }}" min="0">
                @error('username')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                  value="{{ old('email') ?? $user->email }}" min="0">
                @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror"
                  value="{{ old('jabatan') ?? $user->jabatan }}" min="0">
                @error('jabatan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <input type="submit" value="Ubah" class="btn btn-success">
              <a href="{{ route('profiles.index') }}" class="btn btn-primary">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</x-layouts.app-layout>