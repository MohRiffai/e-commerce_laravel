@extends('layouts.frontend_ecommerce')

@section('content')
    <div class="container mt-5">
        <h2>Detail Transaksi</h2>
        <form>
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <p>Nama Pelanggan : {{ $riwayattransaction->user->name }}</p>
                        <p>Alamat Tujuan : {{ $riwayattransaction->alamat_kirim }}</p>
                        <p>Total Berat : {{ $riwayattransaction->total_berat }} Gram</p>
                        <p>Ongkir : Rp <?= number_format($riwayattransaction->ongkir) ?>,-</p>
                        <p>Total Harga Barang : Rp <?= number_format($riwayattransaction->subtotal) ?>,-</p>
                        <p>Total Bayar : Rp <?= number_format($riwayattransaction->total) ?>,-</p>
                    </ul>
                </div>
            </div>

            <h3 class="mt-3">Detail Produk</h3>
            <p>No Order : {{ $riwayattransaction->order_id }}</p>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details['items'] as $detail)
                                <tr>
                                    <td><img src="{{ $detail['gambar'] }}" class="img-fluid" width="70" height="70">
                                    </td>
                                    <td>{{ $detail['nama_produk'] }}</td>
                                    <td>{{ $detail['qty'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-3 mb-3">
                <div class="text-center">
                    <button type="button" class="btn btn-primary btn-block col-md-8" id="pay-button">
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $riwayattransaction->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    window.location.href =
                        '{{ route('transaction.success', ['id' => $riwayattransaction->id]) }}';
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
@endsection
