<x-layouts.auth-layout>
    <x-slot:pageTitle>
        Forget Password
        </x-slot>

        <div class="container">
            <div class="card shadow-lg" style="width: 100%">
                <div class="card-body">
                    <center>
                        <img src="/assets/images/inefable.png" alt="Inefable Logo"
                            style="width: 150px;height:150px;object-fit:cover;border: radius 100%;">
                    </center>

                    <form method="post" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id=""
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                            @if(session('status'))
                            <div class="valid-feedback">
                                berhasil
                            </div>
                            @endif
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <input type="submit" value="Submit" class="btn btn-block btn-success">


                            <a href="<?= route('login') ?>" class="btn btn-link">Kembali ke halaman login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</x-layouts.auth-layout>