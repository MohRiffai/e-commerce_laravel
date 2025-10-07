<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        @media print {
            @page {
                size: landscape;
            }

            #printButton {
                display: none;
                /* Tombol tidak akan dicetak */
            }

            table,
            th,
            td {
                border: 1px solid black;
            }

            th,
            td {
                padding: 8px;
                text-align: left;
            }
        }
    </style>
</head>

<body>
    <h2 style="text-align: center">Laporan Penjualan Online</h2>
    <h2 style="text-align: center">Toko Zulaikha</h2>
    @php
        use Carbon\Carbon;
    @endphp
    <p style="text-align: center">Dicetak Pada Tanggal : {{ Carbon::now()->format('d-m-Y') }}</p>
    @if (isset($startDate) && isset($endDate))
        <p style="text-align: center">Periode: {{ $startDate }} s/d {{ $endDate }}</p>
    @endif
    <div class="text-end mt-1 mb-2 ms-2">
        <button id="printButton" class="btn btn-primary print-button">
            <i class="fas fa-download"></i> Cetak atau Download
        </button>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Invoice</th>
                <th>Subtotal</th>
                <th>Ongkir</th>
                <th>Total Bayar</th>
                <th>Tanggal Transaksi</th>
                <th>Konfirmasi Pembayaran</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1 @endphp
            @forelse ($riwayatTransaksi as $item)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item->no_invoice }}</td>
                    <td>Rp{{ number_format($item->subtotal) }}</td>
                    <td>Rp{{ number_format($item->ongkir) }}</td>
                    <td>Rp{{ number_format($item->total) }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>
                        {{ $item->status_owner }}
                    </td>
                    <td>
                        {{ $item->status }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <hr>
    <table>
        <thead>
            <tr>
                <th><b>Total Penjualan Kotor :</b></th>
                <th><b>Rp {{ number_format($totalPenjualanKotor) }},-</b></th>
            </tr>
            <tr>
                <th><b><b>Total Ongkir:</b></b></th>
                <th><b>Rp {{ number_format($totalOngkir) }},-</b></th>
            </tr>
            <tr>
                <th><b><b>Total Penjualan Bersih:</b></b></th>
                <th><b></b>Rp {{ number_format($totalPenjualanBersih) }},-</b></th>
            </tr>
        </thead>
    </table>
    <br>
    <h3>Rincian Penjualan Produk</h3>
    <br>
    <div>
        <table>
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
        <table>
            <thead>
                <tr>
                    <th class="col-md-10">Total Produk Terjual : </th>
                    <th style="text-align: center">{{ $totalItemTerjual }}</th>
                </tr>
            </thead>
        </table>
    </div>
    <br>
    <br>
    <font size='4'>Mengetahui, </font>
    <br>
    <font size='4'>Di Sukoharjo, {{ Carbon::now()->format('d-m-Y') }}</font>
    <br>
    <br>
    <font size='4'>Owner Toko Zulaikha</font>
    <br>
    <br>
    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>

</html>
