<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Produk</th>
            <th>Nama Produk</th>
            <th>Variasi</th>
            <th>Warna</th>
            <th>Kategori</th>
            <th>Periode Penjualan</th>
            <th>Jumlah Penjualan</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($salesData as $data)
        @php
        $sales = json_decode($data->sales, true); // Decode JSON sales data
        $rowspan = count($sales); // Menghitung berapa jumlah entri sales
        @endphp

        @foreach($sales as $index => $sale)
        <tr>
            @if($index === 0)
            <td rowspan="{{ $rowspan }}">{{ $no++ }}</td>
            <td rowspan="{{ $rowspan }}">{{ $data->kode_produk }}</td>
            <td rowspan="{{ $rowspan }}">{{ $data->nama_produk }}</td>
            <td rowspan="{{ $rowspan }}">{{ $data->variasi }}</td>
            <td rowspan="{{ $rowspan }}">{{ $data->warna }}</td>
            <td rowspan="{{ $rowspan }}">{{ $data->nama_kategori }}</td>
            @endif
            <td>{{ $sale['periode_penjualan'] }}</td>
            <td>{{ $sale['jumlah_penjualan'] }}</td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>