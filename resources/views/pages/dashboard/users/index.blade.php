<x-layouts.app-layout>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Pengguna</h3>
          @if(auth()->user()->role == 'admin')
          <div class="card-tools">
            <a href="{{ route('users.create') }}" class="btn btn-success">
              <i class="bi bi-plus-circle"></i> Tambah Data Pengguna
            </a>
          </div>
          @endif
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="dataTable" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>Username</th>
                @if(auth()->user()->role != 'user')
                <th>Role</th>
                @endif
                @if(auth()->user()->role == 'admin')
                <th>Action</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @if(!$users->isEmpty())
              @foreach($users as $user)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->jabatan }}</td>
                <td>{{ $user->username }}</td>
                @if(auth()->user()->role != 'user')
                <td>{{ $user->role }}</td>
                @endif

                @if(auth()->user()->role == 'admin')
                <td>
                  <button class="btn btn-danger btn-sm ml-1 delete-btn" onclick="confirmDelete(this)"
                    data-delete-url="{{ route('users.destroy', $user) }}">
                    Hapus
                  </button>

                  <a href="{{ route('users.edit', $user)}}" class="btn btn-warning btn-sm">Ubah</a>
                </td>
                @endif
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
      function confirmDelete(button) {
        const deleteUrl = $(button).data('delete-url');

        Swal.fire({
          title: 'Konfirmasi Penghapusan',
          text: 'Apakah Anda yakin ingin menghapus data user ini?',
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
                    'Data user telah dihapus.',
                    'success'
                  ).then(() => {
                    window.location.reload();
                  });
                } else {
                  Swal.fire(
                    'Error!',
                    'Gagal menghapus data user.',
                    'error'
                  );
                }
              },
              error: function (xhr, status, error) {
                Swal.fire(
                  'Error!',
                  'Terjadi kesalahan saat menghapus data user.',
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