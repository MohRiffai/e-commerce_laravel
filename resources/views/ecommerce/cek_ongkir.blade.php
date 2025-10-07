@extends('layouts.frontend_ecommerce')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="col-sm-4 mt-1"><h3><b>Pilih Jasa Pengiriman</b></h3></div>
                    <form action="{{ route('simpan.ongkir') }}" method="POST">
                        @csrf
                        <div class='mt-3'>
                            @if ($ongkir != '')
                                <h5>
                                    <ul>
                                        {{-- <p>Asal Paket : {{ $ongkir['origin_details']['city_name'] }}</p> --}}
                                        <p>Nama Penerima : {{ $riwayatTransaksii->user->name }}</p>
                                        <p>Kota Tujuan  : {{ $riwayatTransaksi['alamat'] }},
                                            {{ $ongkir['destination_details']['city_name'] }},
                                            {{ $ongkir['destination_details']['province'] }}</p>
                                        <p>Berat Paket : {{ $ongkir['query']['weight'] }} gram</p>
                                    </ul>
                                </h5>
                                @foreach ($ongkir['results'] as $item)
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <h6 class="card-title text-center">{{ $item['name'] }}</h6>
                                            <div class="row justify-content-center">
                                                @foreach ($item['costs'] as $cost)
                                                    <div class="col-sm-3 mb-3 mt-2">
                                                        <div class="btn btn-success btn-md d-flex flex-column align-items-center text-center"
                                                            onclick="selectShippingCost({{ $cost['cost'][0]['value'] }})">
                                                            <div class="fw-bold">{{ $cost['service'] }}</div>
                                                            @foreach ($cost['cost'] as $harga)
                                                                <div>Rp {{ $harga['value'] }}</div>
                                                                <div>est: {{ $harga['etd'] }}
                                                                    @if ($item['name'] !== 'POS Indonesia (POS)')
                                                                        HARI
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="card">
                            <div class="row mt-3">
                                <div class="col">
                                    <h4>Ongkir</h4>
                                </div>
                                <div class="col">
                                    <h4>:</h4>
                                </div>
                                <div class="form-group col-md-5">
                                    <input type="number" class="form-control" name="ongkir" id="ongkir" placeholder="0" readonly>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col">
                                    <h4>Subtotal</h4>
                                </div>
                                <div class="col">
                                    <h4>:</h4>
                                </div>
                                <div class="form-group col-md-5">
                                    <input type="number" class="form-control" name="subtotal" id="subtotal" value="{{ $riwayatTransaksi['subtotal'] }}" readonly>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col">
                                    <h4>TOTAL</h4>
                                </div>
                                <div class="col">
                                    <h4>:</h4>
                                </div>
                                <div class="form-group col-md-5">
                                    <input type="number" class="form-control" name="total" id="total" placeholder="0" readonly>
                                </div>
                            </div>
                            <input type="hidden" name="riwayat_transaksi_id" value="{{ $riwayatTransaksi->id }}">
                            <input type="hidden" name="alamat_kirim" id="alamat_kirim" value="{{ $riwayatTransaksi['alamat'] }}, {{ $ongkir['destination_details']['city_name'] }}, {{ $ongkir['destination_details']['province'] }}">                            
                            <input type="hidden" name="jasa_kurir" value="{{ $item['name'] }}">
                            <input type="hidden" name="service" value="{{ $cost['service'] }}">
                            <input type="hidden" name="est_kirim" value="{{ $harga['etd'] }}">
                            <div class="row mt-3 mb-3">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-block col-md-8">Lanjutkan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function selectShippingCost(cost) {
        // Set ongkir value
        document.getElementById('ongkir').value = cost;

        // Get subtotal value
        var subtotal = parseFloat(document.getElementById('subtotal').value);

        // Calculate total
        var total = subtotal + cost;

        // Set total value
        document.getElementById('total').value = total;
    }
</script>