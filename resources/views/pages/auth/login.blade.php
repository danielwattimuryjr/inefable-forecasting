<x-layouts.auth-layout>
  <x-slot:pageTitle>
    Login
    </x-slot>

    <div class="center">
      <div class="container">
        <center>
          <img src="/assets/images/inefable.png" alt="Inefable Logo"
            style="width: 150px;height:150px;object-fit:cover;border: radius 100%;">
        </center>
        <form method="post">
          <div class="data">
            <label>Username</label>
            <input type="text" name="username" required>
          </div>
          <div class="data">
            <label>Password</label>
            <input type="password" name="password" required>
          </div>
          <div class="btn">
            <div class="inner"></div>
            <button type="submit">Login</button>
          </div>
          <div class="signup-link">
            <a href="forgot_password_form.php">Lupa Password</a>
          </div>
        </form>
      </div>
    </div>
</x-layouts.auth-layout>