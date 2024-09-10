<aside class="main-sidebar sidebar-light-primary elevation-4 " style="background-color: #fcfcfc;">
  <!-- Brand Logo -->
  <center>
    <img src="/assets/images/inefable.png" alt="inefable" width="150px" height="150px"
      style="border-radius: 100%;object-fit:cover;margin-top:10px;">
    <!-- <h3 href="index.php" class="brand-link" style="text-transform: uppercase;">
            INEFABLE
        </h3> -->
  </center>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel pb-3 mb-3 d-flex">
      <div class="image">
        <img src="/template/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" />
      </div>
      <div class="info">
        <a href="index.php" class="d-block">
          {{ auth()->user()->username}}
        </a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Beranda
          </p>
        </x-nav-link>

        @if(auth()->user()->role == 'direktur_operasional')

        <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.*')">
          <i class="nav-icon fas fa-shopping-cart"></i>
          <p>Data Penjualan</p>
        </x-nav-link>

        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
          <i class="nav-icon fas fa-box"></i>
          <p>Data Produk</p>
        </x-nav-link>

        <x-nav-link :href="route('productCategories.index')" :active="request()->routeIs('productCategories.*')">
          <i class="nav-icon fas fa-box"></i>
          <p>Data Jenis Produk</p>
        </x-nav-link>

        <x-nav-link :href="route('forecasts.index')" :active="request()->routeIs('forecasts.*')">
          <i class="nav-icon fas fa-calculator"></i>
          <p>
            Prediksi
          </p>
        </x-nav-link>
        @endif
        @if(auth()->user()->role == 'admin')
        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
          <i class="nav-icon fas fa-user-plus"></i>
          <p>
            Data Pengguna
          </p>
        </x-nav-link>
        @endif

        @if(auth()->user()->role == 'user')
        <x-nav-link :href="route('forecasts.index')" :active="request()->routeIs('forecasts')">
          <i class="nav-icon fas fa-calculator"></i>
          <p>
            Lihat Prediksi
          </p>
        </x-nav-link>
        @endif

        <x-nav-link :href="route('profiles.index')" :active="request()->routeIs('profiles.*')">
          <i class="nav-icon fas fa-clipboard-check"></i>
          <p>
            Profile
          </p>
        </x-nav-link>


        <form method="POST" action="{{ route('logout') }}" class="mt-2">
          @csrf
          <input type="submit" value="Logout" class="btn btn-sm btn-danger" style="width: 100%;">
        </form>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>