<x-layouts.app-layout>
  @php
  $roles = [
  'admin' => 'Admin',
  'user' => 'User',
  'direktur_operasional' => 'Direktur Operasional'
  ];
  @endphp
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tambah Data User</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form action="{{ route('users.store') }}" method="post">
            @csrf
            <div class="form-group">
              <div class="form-group">
                <label for="nama">Nama Pengguna</label>
                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                  value="{{ old('nama') }}">
                @error('nama')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                  value="{{ old('username') }}" min="0">
                @error('username')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                  value="{{ old('email') }}" min="0">
                @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="" class="form-control @error('role') is-invalid @enderror">
                  <option disabled selected>
                    -- PILIH ROLE --
                  </option>
                  @foreach ($roles as $key => $role)
                  <option value="{{ $key }}" {{ old('role')==$key ? 'selected' : '' }}>
                    {{ $role }}
                  </option>

                  @endforeach
                </select>
                @error('role')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror"
                  value="{{ old('jabatan') }}" min="0">
                @error('jabatan')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                  value="{{ old('password') }}" min="0">
                @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <input type="submit" value="Tambah" class="btn btn-success">
              <a href="{{ route('users.index') }}" class="btn btn-primary">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</x-layouts.app-layout>