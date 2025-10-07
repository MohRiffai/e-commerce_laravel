<x-app-layout>
    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-x1 text-gray-800 leading-tight text-justify">
                {{ __('Laporan Penjualan Online') }}
            </h2>
        </x-slot>
        <div class="container mt-4">
            <div class="row">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-rounded card-kasir-transparent shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Total Penjualan Kotor</h5>
                                <div class="d-none d-lg-block">
                                    <div id="totalPenjualan">
                                        <h3>Rp {{ number_format($totalPenjualanKotor) }},-</h3>
                                    </div>
                                </div>
                                <h5 class="card-title">Total Ongkir</h5>
                                <div class="d-none d-lg-block">
                                    <div id="totalPenjualan">
                                        <h3>Rp {{ number_format($totalOngkir) }},-</h3>
                                    </div>
                                </div>
                                <hr>
                                <h5 class="card-title">Total Penjualan Bersih</h5>
                                <div class="d-none d-lg-block">
                                    <div id="totalPenjualan">
                                        <h3>Rp {{ number_format($totalPenjualanBersih) }},-</h3>
                                        <div>
                                            <a href="{{ route('cetak_penjualan_online_semua') }}" class="btn btn-info">Cetak Semua
                                                Penjualan</a>
                                        </div>
                                    </div>
                                    @if (isset($startDate) && isset($endDate))
                                        <div>
                                            <a href="{{ route('penjualan_online') }}" class="btn btn-primary mt-2"><i
                                                    class="fas fa-arrow-left"></i> Kembali</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-rounded card-kasir-transparent shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Periode</h5>
                                <div class="d-none d-lg-block">
                                    <div>
                                        <form action="{{ route('cek_penjualan_online') }}" method="GET">
                                            <p>Dari : <input type="date" name="start_date" id="start_date"
                                                    placeholder="yyyy-mm-dd"> s/d <input type="date" name="end_date"
                                                    id="end_date" placeholder="yyyy-mm-dd"> </p>
                                            <button type="submit" class="btn btn-primary mt-1 mb-2">Cek Penjualan</button>
                                        </form>
                                        <hr>
                                        <form action="{{ route('cetak_penjualan_online_tanggal') }}" method="GET">
                                            <p>Dari : <input type="date" name="start_date" id="start_date"
                                                    placeholder="yyyy-mm-dd"> s/d <input type="date" name="end_date"
                                                    id="end_date" placeholder="yyyy-mm-dd"> </p>
                                            <button type="submit" class="btn btn-success mt-1 mb-2">Cetak Penjualan Berdasarkan Tanggal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (isset($startDate) && isset($endDate))
                        <div>
                            <h3>Periode: {{ $startDate }} s/d {{ $endDate }}</h3>
                        </div>
                    @endif
                    <div class="container-penjualan">
                        <div class="item-penjualan">
                            <a href="{{ route('laporan_penjualan.index') }}" class="btn btn-outline-primary">Semua Pejualan</a>
                            <a href="{{ route('penjualan_online') }}" class="btn btn-outline-primary {{ request()->routeIs('penjualan_online') ? 'active' : '' }} {{ request()->routeIs('cek_penjualan_online') ? 'active' : '' }}">Penjualan Online (Toko Online)</a>
                            <a href="{{ route('penjualan_offline') }}" class="btn btn-outline-primary">Penjualan Offline (Kasir)</a>
                        </div>
                    </div>
                    <div class="card card-rounded mt-2">
                        <div class="card-header text-white bg-success">
                            <h5 class="card-title pt-2"> <i class="fas fa-database me-1"></i> Data Penjualan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4 ms-auto">
                                    <form class="d-flex" action="{{ route('penjualan_online') }}" method="GET">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input class="form-control" type="search" name="keywords"
                                                value="{{ request('keywords') }}" placeholder="Cari Transaksi..."
                                                aria-label="Search">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive mt-1">
                                <table class="table table-striped table-bordered" id="example1">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor Invoice</th>
                                            <th>Pembeli</th>
                                            <th>Subtotal</th>
                                            <th>Ongkir</th>
                                            <th>Total Bayar</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Konfirmasi Pembayaran</th>
                                            <th>Status Pembayaran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1 @endphp
                                        @forelse ($riwayatTransaksi as $item)
                                            <tr>
                                                <input type="hidden" name="transaksi_id" value="{{ $item->id }}">
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->no_invoice }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                <td>Rp{{ number_format($item->subtotal) }}</td>
                                                <td>Rp{{ number_format($item->ongkir) }}</td>
                                                <td>Rp{{ number_format($item->total) }}</td>
                                                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                                <td
                                                    style="background-color: {{ $item->status_owner === 'pending' ? 'yellow' : ($item->status_owner === 'success' ? 'green' : 'white') }}; color: {{ $item->status_owner === 'success' ? 'white' : 'black' }}; text-align: center;">
                                                    {{ $item->status_owner }}
                                                </td>
                                                <td
                                                    style="background-color: {{ $item->status === 'pending' ? 'yellow' : ($item->status === 'success' ? 'green' : 'white') }}; color: {{ $item->status === 'success' ? 'white' : 'black' }}; text-align: center;">
                                                    {{ $item->status }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('invoice_online', $item->id) }}" class="btn btn-primary">Konfirmasi / Lihat Rincian Pembayaran</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data transaksi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{-- {{ $riwayatTransaksi->links() }} --}}
                        </div>
                    </div>
                    <div class="card card-rounded mt-2 mb-3 col-md-5">
                        <div class="card-header text-white bg-success">
                            <h5 class="card-title pt-2"> <i class="fas fa-database me-1"></i> Data Barang Terjual</h5>
                        </div>
                        <div class="table-responsive mt-1">
                            <table class="table table-striped table-bordered" id="example2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="col-md-10">Nama Produk</th>
                                        <th class="col-md-10">Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1 @endphp
                                    @forelse ($barangTerjual as $barang)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $barang['nama_produk'] }}</td>
                                            <td style="text-align: center">{{ $barang['terjual'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak ada data barang terjual</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <hr>
                            <table class="table table-striped table-bordered" id="example2">
                                <thead>
                                    <tr>
                                        <th class="col-md-10">Total Produk Terjual : </th>
                                        <th style="text-align: center">{{ $totalItemTerjual }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <br>
                    </div>
                </div>
            </div>

        </div>
    @endsection
    <script>
        $(document).ready(function() {
            $('#example1').DataTable();
        });
    </script>
    <script>
        // Function untuk menghitung total penjualan
        function hitungTotalPenjualan() {
            var total = 0;
            $('#example1 tbody tr').each(function() {
                var subtotal = parseFloat($(this).find('td:eq(2)').text());
                total += isNaN(subtotal) ? 0 : subtotal;
            });
            $('#totalPenjualan').text('Rp ' + total.toFixed(2) + ' ,-');
        }

        $(document).ready(function() {
            $('#example1').DataTable();

            // Panggil function hitungTotalPenjualan saat halaman dimuat
            hitungTotalPenjualan();
        });
    </script>
</x-app-layout>
