<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $pageTitle ?? env('APP_NAME', 'Inefable Forecasting')}}</title>
  <link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css" />
  <link rel="stylesheet" href="/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
  <link rel="stylesheet" href="/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
  <link rel="stylesheet" href="/template/plugins/jqvmap/jqvmap.min.css" />
  <link rel="stylesheet" href="/template/dist/css/adminlte.min.css" />
  <link rel="stylesheet" href="/template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
  <link rel="stylesheet" href="/template/plugins/daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" href="/template/plugins/summernote/summernote-bs4.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
  {{ $styles ?? '' }}
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="/template/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
        width="60" />
    </div>

    @include('components.partials.navbar')
    @include('components.partials.sidebar')


    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              @if (request()->routeIs('dashboard'))
              <h1>Selamat Datang, {{ auth()->user()->nama }}</h1>
              @endif
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Inefable v1</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        {{$slot}}
      </div>
    </div>

    @include('components.partials.footer')

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>

  <script src="/template/plugins/jquery/jquery.min.js"></script>
  <script src="/template/plugins/jquery-ui/jquery-ui.min.js"></script>
  <script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/template/plugins/chart.js/Chart.min.js"></script>
  <script src="/template/plugins/sparklines/sparkline.js"></script>
  <script src="/template/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="/template/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <script src="/template/plugins/jquery-knob/jquery.knob.min.js"></script>
  <script src="/template/plugins/moment/moment.min.js"></script>
  <script src="/template/plugins/daterangepicker/daterangepicker.js"></script>
  <script src="/template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <script src="/template/plugins/summernote/summernote-bs4.min.js"></script>
  <script src="/template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="/template/dist/js/adminlte.js"></script>
  <script src="/template/dist/js/demo.js"></script>
  <script src="/template/dist/js/pages/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.21/jspdf.plugin.autotable.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
  @if(session('response'))
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      @if (session('response.success'))
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: "{{ session('response.message') }}",
        });
      @else
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "{{ session('response.message') }}",
      });
      @endif
    });
  </script>
  @endif

  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable();
    })
  </script>

  {{ $script ?? '' }}
</body>

</html>