<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body data-spy="scroll" data-target=".navbar-custom">
    <div class="container">
        <nav class="top">
            <div class="container-nav">
                <h1 style="text-align:left; color: #47993a"><b>Toko Zulaikha</b></h1>
                <button id="printButton" class="btn btn-primary"><i class="fa fa-download"></i> Cetak atau Download Invoice</button>
            </div>
            <a href="{{ route('penjualan_online') }}" class="btn btn-primary" id="backButton"><i class="fa fa-arrow-left"></i> Kembali</a>  
        </nav>
        <div>
            <h3 style="text-align:right"><b>Invoice</b></h3>
            <p style="text-align:right; color:#47993a">{{ $transaksi->no_invoice }}</p>
        </div>
        <p class="mb-1"><b>UNTUK</b></p>
        <div>
            <table class="info-table">
                <tr>
                    <td>Pembeli</td>
                    <td>: {{ $transaksi->user->name }}</td>
                </tr>
                <tr>
                    <td>Tanggal Pembelian</td>
                    <td>: {{ \Carbon\Carbon::parse($transaksi->created_at)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>Alamat Pengiriman</td>
                    <td>: {{ $transaksi->alamat_kirim }}</td>
                </tr>
            </table>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 table-container">
                <table class="table table-striped">
                    <p><b>No Order :</b> {{ $transaksi->order_id }}</p>
                    <thead>
                        <tr>
                            <th style="text-align:left">NAMA PRODUK</th>
                            <th style="text-align:right">JUMLAH</th>
                            <th style="text-align:right">HARGA SATUAN</th>
                            <th style="text-align:right">TOTAL HARGA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details['items'] as $detail)
                            <tr>
                                <td style="color:#47993a"><b>{{ $detail['nama_produk'] }}</b></td>
                                <td>{{ $detail['qty'] }}</td>
                                <td>Rp {{ number_format($detail['harga_produk']) }}</td>
                                <td>Rp {{ number_format($detail['subtotal']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align:right"><b>TOTAL HARGA</b></td>
                            <td style="text-align:right"> <b>Rp{{ number_format($transaksi->subtotal) }}</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right">Total Ongkos Kirim</td>
                            <td style="font-size:15px; text-align:right"> Rp{{ number_format($transaksi->ongkir) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right"><b>TOTAL TAGIHAN</b></td>
                            <td style="text-align:right"> <b>Rp{{ number_format($transaksi->total) }}</b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div>
            {{-- <p>Status Pembayaran : <b style="color:#47993a">{{ $transaksi->status_transaksi }}</b> </p> --}}
            <p>Status Pembayaran : 
                <b style="color: 
                @if ($transaksi->status_transaksi == 'LUNAS')
                    #47993a
                @elseif ($transaksi->status_transaksi == 'BELUM LUNAS')
                    red
                @endif
            ">
                {{ $transaksi->status_transaksi }}
            </b>
            </p>
            <p>Status Owner : 
                <b style="color: 
                @if ($transaksi->status_owner == 'success')
                    #47993a
                @elseif ($transaksi->status_owner == 'pending')
                    #FFEA00
                @endif
            ">
                {{ $transaksi->status_owner }}
            </b>
            </p>
        </div>
        <div>
            <p>Kurir : </p>
            <p><b>{{ $transaksi->jasa_kurir }} - {{ $transaksi->service }}</b></p>
        </div>
        <form action="{{ route('updateStatusOwner', $transaksi->id) }}" method="POST" class="hide-on-print">
            @csrf
            @method('PUT')
            <div class="form-group mt-3">
                <label for="courier">Status Transaksi</label>
                <select class="form-select" name="status_owner" id="status" required>
                    <option>Pilih Status Transaksi</option>
                    <option value="pending">Pending</option>
                    <option value="success">Success</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success btn-md mt-4">Simpan</button>
        </form>
        <!-- Tambahkan informasi tambahan yang diperlukan -->
    </div>
    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>

</html>
