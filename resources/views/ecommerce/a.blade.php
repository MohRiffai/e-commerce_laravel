@extends('layouts.frontend_ecommerce')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="col-sm-4"><b>Masukan Alamat Anda</b></div>
                    <p class="text-danger">(Pastikan alamat anda benar!)</p>
                    <form action="" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="street">
                                <label for="street">Jalan</label>
                                <input type="text" class="form-control @error('street') is-invalid @enderror" required
                                    name="street" id="street" value="{{ old('street') }}">
                            </div>
                            <div class="form-group mt-3">
                                <label for="destination">Kota Tujuan</label>
                                <select class="form-select" name="destination" id="destination" required>
                                    <option value="">Pilih Kota</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label for="weight">Berat Paket (gram)</label>
                                <input type="number" class="form-control" name="weight" id="weight" placeholder="0"
                                    readonly>
                            </div>
                            <div class="form-group mt-3">
                                <label for="courier">Jasa Pengiriman</label>
                                <select class="form-select" name="courier" id="courier" required>
                                    <option value="">Pilih Kurir</option>
                                    <option value="jne">JNE</option>
                                    <option value="pos">POS</option>
                                    <option value="tiki">TIKI</option>
                                </select>
                            </div>
                            <button class="btn btn-success btn-md mt-4" name="cekOngkir" type="submit">Lihat Daftar
                                Ongkir</button>
                        </div>
                        <div class='mt-3'>
                            @if ($ongkir != '')
                                <h5>Rincian Ongkir</h5>
                                <h5>
                                    <ul>
                                        <p>Asal Paket : {{ $ongkir['origin_details']['city_name'] }}</p>
                                        <p>Kota Tujuan : {{ $data['street'] }},
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
                                                        <div
                                                            class="btn btn-success btn-md d-flex flex-column align-items-center text-center"
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
                    </form>
                </div>
            </div>
            <div class="col-md-6 mt-1">
                <div class="card">
                    <div class="col-sm-4"><b>Product List:</b></div>
                    <p class="text-danger">(Pastikan produk yang anda pilih sudah benar!)</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Berat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (session('cart'))
                                @foreach (session('cart') as $key => $product)
                                    <tr>
                                        <td><img src="{{ $product['gambar'] }}" class="img-fluid" style="max-width: 80px;"></td>
                                        <td>{{ $product['nama_produk'] }}</td>
                                        <td>{{ $product['harga_produk'] }}</td>
                                        <td>{{ $product['berat'] }} gram</td>
                                        <input type="hidden" class="form-control" name="qty" id="qty" value="1" required>
                                        <td>
                                            <form action="{{ route('cart.remove', $key) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">Keranjang kosong</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card">
                    <div class="row mt-3">
                        <div class="col">
                            <h4>Subtotal</h4>
                        </div>
                        <div class="col">
                            <h4>:</h4>
                        </div>
                        <div class="form-group col-md-5">
                            <input type="number" class="form-control" name="subtotal" id="subtotal" placeholder="0"
                                readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <h4>Ongkir</h4>
                        </div>
                        <div class="col">
                            <h4>:</h4>
                        </div>
                        <div class="form-group col-md-5">
                            <input type="number" class="form-control" name="ongkir" id="ongkir" placeholder="0"
                                readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col">
                            <h4>TOTAL</h4>
                        </div>
                        <div class="col">
                            <h4>:</h4>
                        </div>
                        <div class="form-group col-md-5">
                            <input type="number" class="form-control" name="total" id="total" placeholder="0"
                                readonly>
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="text-center">
                            <a href="" class="btn btn-success btn-block col-md-8">
                                <i class="fas fa-shopping-cart"></i> Bayar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    // Fungsi untuk menyimpan input ke dalam localStorage
    function saveInput() {
        var input = document.getElementById('qty').value;
        localStorage.setItem('savedInput', input);
    }

    // Memeriksa apakah ada input yang disimpan sebelumnya
    window.onload = function() {
        var savedInput = localStorage.getItem('savedInput');
        if(savedInput) {
            document.getElementById('qty').value = savedInput;
        }
    }
</script>

<script>
    // Fungsi untuk menyimpan input ke dalam localStorage
    function saveInput() {
        var input = document.getElementById('berat').value;
        localStorage.setItem('savedInput', input);
    }

    // Memeriksa apakah ada input yang disimpan sebelumnya
    window.onload = function() {
        var savedInput = localStorage.getItem('savedInput');
        if(savedInput) {
            document.getElementById('berat').value = savedInput;
        }
    }
</script>

<script>
    // Fungsi untuk menyimpan input ke dalam localStorage
    function saveInput() {
        var input = document.getElementById('qty').value;
        localStorage.setItem('savedInput', input);
    }

    // Memeriksa apakah ada input yang disimpan sebelumnya
    window.onload = function() {
        var savedInput = localStorage.getItem('savedInput');
        if(savedInput) {
            document.getElementById('qty').value = savedInput;
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        function updateTotals() {
            let totalWeight = 0;
            let subtotal = 0;

            document.querySelectorAll('tbody tr').forEach(row => {
                const weight = parseFloat(row.querySelector('td:nth-child(4)').textContent) || 0;
                const price = parseFloat(row.querySelector('td:nth-child(3)').textContent) || 0;
                const qty = parseFloat(row.querySelector('input[name="qty"]').value) || 0;

                totalWeight += weight * qty;
                subtotal += price * qty;
            });

            document.getElementById('weight').value = totalWeight;
            document.getElementById('subtotal').value = subtotal;

            const ongkir = parseFloat(document.getElementById('ongkir').value) || 0;
            document.getElementById('total').value = subtotal + ongkir;
        }

        document.querySelectorAll('input[name="qty"]').forEach(input => {
            input.addEventListener('input', updateTotals);
        });

        document.getElementById('ongkir').addEventListener('input', updateTotals);

        updateTotals();
    });

    function selectShippingCost(cost) {
        document.getElementById('ongkir').value = cost;
        const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
        document.getElementById('total').value = subtotal + cost;
    }
</script>