<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="{{ asset('css/invoice.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-size: 12px;
            line-height: 1.2;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }

        table {
            width: 100%;
            table-layout: fixed;
        }

        td,
        th {
            word-wrap: break-word;
            white-space: normal;
        }
        

        @media print {
            body {
                font-size: 10px;
            }

            .container {
                padding: 10px;
            }

            .table-container {
                max-height: none;
                overflow: visible;
            }

            .top,
            .lunas {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .lunas {
                margin-top: 10px;
            }

            .table-container table {
                margin-bottom: 0;
            }

            @media print {
                #printButton {
                    display: none;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th,
                td {
                    border: 1px solid #dee2e6;
                    padding: 8px;
                    text-align: right;
                }

                th {
                    background-color: #f8f9fa;
                    color: #333;
                }

                td {
                    color: #000;
                }


                .table-container {
                    box-shadow: none;
                }

                body {
                    margin: 0;
                    padding: 0;
                    -webkit-print-color-adjust: exact;
                }

                body, p, td, th {
                    font-size: 12pt;
                }
                .container {
                    page-break-inside: avoid;
                }
            }
        }
    </style>
</head>

<body data-spy="scroll" data-target=".navbar-custom">
    <div class="container">
        <nav class="top">
            <div class="container-nav">
                <h1 style="text-align:left; color: #47993a"><b>Toko Zulaikha</b></h1>
                <button id="printButton" class="btn btn-primary"><i class="fa fa-download"></i> Cetak atau Download
                    Invoice</button>
            </div>
        </nav>
        <div>
            <h3 style="text-align:right"><b>Invoice</b></h3>
            <p style="text-align:right; color:#47993a">{{ $transaksi->no_invoice }}</p>
        </div>
        <p class="mb-1"><b>UNTUK</b></p>
        <div>
            <table class="info-table">
                <tr>
                    <td class="col-md-2" style="text-align: left">Pembeli</td>
                    <td style="text-align: left">: {{ $transaksi->user->name }}</td>
                </tr>
                <tr>
                    <td style="text-align: left">Tanggal Pembelian</td>
                    <td style="text-align: left">: {{ \Carbon\Carbon::parse($transaksi->created_at)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td style="text-align: left">Alamat Pengiriman</td>
                    <td style="text-align: left">: {{ $transaksi->alamat_kirim }}</td>
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
                                <td style="text-align: right">{{ $detail['qty'] }}</td>
                                <td style="text-align: right">Rp {{ number_format($detail['harga_produk']) }}</td>
                                <td style="text-align: right">Rp {{ number_format($detail['subtotal']) }}</td>
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
        <div class="lunas">
            <p>Status Pembayaran : <b style="color:#47993a">{{ $transaksi->status_transaksi }}</b> </p>
        </div>
        <div>
            <p>Kurir : </p>
            <p><b>{{ $transaksi->jasa_kurir }} - {{ $transaksi->service }}</b></p>
        </div>

        <!-- Tambahkan informasi tambahan yang diperlukan -->
    </div>
    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>

</html>
