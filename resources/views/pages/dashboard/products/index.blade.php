<x-layouts.app-layout>
    <x-slot:pageTitle>
        Products
    </x-slot:pageTitle>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Data Penjualan</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" class="mt-3" onsubmit="return validateForm()" id="produkForm">
            <div class="card-body">
                <div class="form-group">
                    <label for="id_produk">Produk:</label>
                    <select name="id_produk" class="form-control" id="id_produk" name="id_produk">
                        <option value="">Pilih terlebih dahulu</option>

                    </select>
                </div>
                <div class="form-group">
                    <label for="periode">Periode:</label>
                    <select name="periode" class="form-control" id="periode">

                    </select>
                </div>
                <div class="form-group">
                <label for="tahun">Tahun:</label>
                <input type="number" name="tahun" class="form-control" id="tahun" maxLength="4" required>
                </div>
                <div class="form-group">
                <label for="jmlh_penjualan">Jumlah Penjualan:</label>
                <input type="number" name="jmlh_penjualan" class="form-control" id="jmlh_penjualan" required>
                <div id="error-message" class="error-message">Jumlah Penjualan tidak boleh negatif.
                </div>
                </div>
                <button type="submit" class="btn btn-success">Tambah Data</button>
                <a href="data_penjualan.php" class="btn btn-primary">Kembali</a>
            </div>
        </form>
    </div>
</x-layouts.app-layout>