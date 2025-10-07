<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-area, .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            @page {
                size: auto;
                margin: 0;
            }
        }
    </style>
</head>

<body data-spy="scroll" data-target=".navbar-custom">
    <div class="container mt-4 d-flex justify-content-center">
        <div class="card print-area" style="width: 560px;">
            <div class="card-body">
                <h3 class="text-center">Toko Zulaikha</h3>
                <hr>
                <div class="card-header text-center">
                    Nota Transaksi: {{ $transaction->no_nota }}
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center">Detail Transaksi</h5>
                    <p class="card-text text-center">Tanggal: {{ $transaction->created_at }}</p>
                    <hr>
                    <ul class="list-group mb-3">
                        @foreach (json_decode($transaction->details) as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $item->product_name }} - {{ $item->quantity }} x Rp{{ number_format($item->price) }}</span>
                                <span>Rp{{ number_format($item->quantity * $item->price) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <hr>
                    <p class="card-text text-right" style="text-align: right">Total: Rp{{ number_format($transaction->total) }}</p>
                    <p class="card-text text-right" style="text-align: right">Cash: Rp{{ number_format($transaction->cash) }}</p>
                    <p class="card-text text-right" style="text-align: right">Kembalian: Rp{{ number_format($transaction->kembalian) }}</p>
                </div>
                <div class="text-center mt-3">
                    <button id="printButton" class="btn btn-primary print-button">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('printButton').addEventListener('click', function () {
            window.print();
        });
    </script>
</body>

</html>
