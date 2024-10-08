<x-layouts.app-layout>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Penjualan</h3>
                    <div class="card-tools">
                        <a href="{{ route('sales.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Tambah Data Penjualan
                        </a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import-modal">
                            Import
                        </button>
                        <a href="<?= route('exports.sales') ?>" class="btn btn-info">
                            <i class="bi bi-download"></i>Template
                        </a>

                        <div class="modal fade" id="import-modal" tabindex="-1" aria-labelledby="import-modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="importModalLabel">Import Data Penjualan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('imports.sales') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>File (*.xls or *.xlsx)</label>
                                                <input type="file" class="form-control" name="file" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <p class="mb-4">
                        <i>Note : Klik <b>Template</b> untuk mengunduh template excel untuk melakukan import</i>
                    </p>
                    <p class="mb-4">
                        <i>Note : Import Excel harus menggunakan template yang sudah tersedia atau file dari
                            export
                            excel</i>
                    </p>

                    <table id="dataTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Warna</th>
                                <th>Variasi</th>
                                <th>Total Penjualan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$products->isEmpty())
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->kode_produk }}</td>
                                <td>{{ $product->nama_produk }}</td>
                                <td>{{ $product->warna }}</td>
                                <td>{{ $product->variasi }}</td>
                                <td>{{ number_format($product->sales_sum_jumlah_penjualan) ?? 0 }}</td>
                                <td>
                                    <a href="{{ route('products.show', $product )}}"
                                        class="btn btn-primary btn-sm">Detail</a>
                                </td>
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
</x-layouts.app-layout>