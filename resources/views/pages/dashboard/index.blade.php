<x-layouts.app-layout>
  <x-slot:style>
    <style>
      .small-box .icon i.fas.fa-tshirt {
        font-size: 70px;
        top: 20px;
      }

      /* Make the button smaller */
      .btn-arrow {
        font-size: 12px;
        /* Smaller font size */
        padding: 5px 10px;
        /* Smaller padding */
        position: absolute;
        /* Absolute positioning */
        bottom: 10px;
        /* Distance from the bottom */
        right: 10px;
        /* Distance from the right */
      }

      /* Ensure the container is positioned relatively */
      .small-box.position-relative {
        position: relative;
      }
    </style>
  </x-slot:style>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        @foreach($jenis as $j)
        <div class="col-lg-3">
          <div class="small-box bg-info position-relative">
            <div class="inner">
              <h6>Jenis Produk</h6>
              <h4>{{ $j->nama_kategori }}</h4>
              <p>Total Produk : {{ $j->product_count }}</p>

              <button class="btn btn-light btn-sm btn-arrow" data-toggle="modal" data-target="#categoryModal"
                data-category-id="{{ $j->id }}" data-category-name="{{ $j->nama_kategori }}">
                <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="categoryModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="modalContent">
              <!-- Dynamic Content will be loaded here via AJAX -->
              <p>Loading...</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <x-slot:script>
    <script>
      $(document).ready(function () {
        $('.btn-arrow').click(function () {
          var categoryId = $(this).data('category-id'); // Get the category ID
          var categoryName = $(this).data('category-name'); // Get the category name

          // Update modal title
          $('#categoryModalLabel').text(categoryName);

          // Make the Ajax request
          $.ajax({
            url: '/get-category-products', // Route that handles the request
            type: 'GET',
            data: {
              id: categoryId
            },
            success: function (response) {
              // If products are found, build the table
              if (response.products.length > 0) {
                var tableHtml = '<table class="table table-bordered table-hover"><thead><tr><th>No</th><th>Nama Produk</th></tr></thead><tbody>';

                $.each(response.products, function (index, product) {
                  tableHtml += '<tr><td>' + (index + 1) + '</td><td>' + product.nama_produk + '</td></tr>';
                });

                tableHtml += '</tbody></table>';
                $('#modalContent').html(tableHtml);
              } else {
                $('#modalContent').html('<p>Belum ada produk untuk jenis ini.</p>');
              }
            },
            error: function (xhr, status, error) {
              // Handle error
              $('#modalContent').html('Something went wrong. Please try again.');
            }
          });
        });
        // Trigger modal with data-category-id
      });
    </script>
    </x-slot:scripts>
</x-layouts.app-layout>