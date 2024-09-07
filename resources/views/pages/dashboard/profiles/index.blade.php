<x-layouts.app-layout>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Profile Pengguna</h3>
          <div class="card-tools">
            <a href="{{ route('profiles.edit') }}" class="btn btn-warning">
              Edit
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-sm table-borderless">
                <tr>
                  <th>Nama Pengguna</th>
                  <th>:</th>
                  <td>{{ $user->nama }}</td>
                </tr>
                <tr>
                  <th>Username</th>
                  <th>:</th>
                  <td>{{ $user->username }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <th>:</th>
                  <td>{{ $user->email }}</td>
                </tr>
                <tr>
                  <th>Role</th>
                  <th>:</th>
                  <td>{{ $user->role }}</td>
                </tr>
                <tr>
                  <th>Jabatan</th>
                  <th>:</th>
                  <td>{{ $user->jabatan }}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-layouts.app-layout>