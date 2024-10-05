<x-layouts.app-layout>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Halaman Prediksi Penjualan</div>
                </div>
                <div class="card-body">
                    @foreach($data['result'] as $d)
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th colspan="3">
                                Nama Produk :
                                {{ $d['nama_produk'] }}
                            </th>
                        </tr>

                        <tr>
                            <td colspan="3">
                                Alpha: {{$d['forecast']['alpha']}} | MAPE: {{ $d['forecast']['mape']}}
                            </td>
                        </tr>

                        <tr>
                            <th>Periode</th>
                            <th>Prediksi</th>
                        </tr>

                        <tr>
                            <td>{{$d['forecast']['month']}}</td>
                            <td>{{$d['forecast']['result']}}</td>
                        </tr>
                    </table>
                    @endforeach
                    <div class="mt-2">
                        <form action="{{ route('forecasts.store', $productCategoryId) }}" method="post"
                            class="mt-3 d-flex flex-row">
                            @csrf
                            <input type="submit" value="Simpan" class="btn btn-success mr-2">

                            <a href="{{ route('forecasts.index') }}" class='btn btn-primary'>Kembali</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-layout>