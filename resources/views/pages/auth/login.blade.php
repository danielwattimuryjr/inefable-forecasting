<x-layouts.auth-layout>
  <x-slot:pageTitle>
    Login
    </x-slot>

    <div class="container">
      <div class="card shadow-lg">
        <div class="card-body">
          <center>
            <img src="/assets/images/inefable.png" alt="Inefable Logo"
              style="width: 150px;height:150px;object-fit:cover;border: radius 100%;">
          </center>
          <form method="post" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" id="" class="form-control @error('username') is-invalid @enderror">
              @error('username')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>

            <div class="form-group mt-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
              @error('password')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>

            <div class="d-grid gap-2 mt-4">
              <input type="submit" value="Login" class="btn btn-block btn-success">


              <a href="<?= route('password.request') ?>" class="btn btn-link">Lupa Password</a>
            </div>
          </form>
        </div>
      </div>
    </div>

</x-layouts.auth-layout>
