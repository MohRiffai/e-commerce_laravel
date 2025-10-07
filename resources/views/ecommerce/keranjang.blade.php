@extends('layouts.frontend_ecommerce')
@section('content')
    <div class="container mt-4">
        <a href="{{ route('home.index') }}" class="btn btn-primary mb-4"><i class="fas fa-arrow-left"></i> Kembali Belanja</a>
        <h2>Keranjang Belanja</h2>
        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            @if (session('cart'))
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Berat (gram)</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (session('cart') as $id => $details)
                                    <tr id="product-row-{{ $id }}">
                                        <td class="col-md-1"><img src="{{ $details['gambar'] }}" class="img-fluid"
                                                width="70" height="70"></td>
                                        <td class="col-md-5">{{ $details['nama_produk'] }}</td>
                                        <td class="col-md-1 berat" data-berat="{{ $details['berat'] }}">
                                            {{ $details['berat'] }}</td>
                                        <td class="col-md-1 harga" data-harga="{{ $details['harga_produk'] }}">
                                            Rp{{ number_format($details['harga_produk']) }}</td>
                                        <td class="col-md-1">
                                            <div class="qty">
                                                <input type="number" class="form-control qty-input"
                                                    name="qty[{{ $id }}]" id="qty-{{ $id }}"
                                                    value="1" min="1" max="{{ $details['stok'] }}" required>
                                                <!-- Tambahkan max -->
                                        <td class="col-md-1">
                                            <input type="hidden" name="subtotal[{{ $id }}]"
                                                id="subtotal-{{ $id }}" value="0">
                                            <span id="subtotal-display-{{ $id }}">Rp0</span>
                                        </td>
                                        <td class="col-md-1">
                                            <div class="text-center">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-danger btn-block col-md-8 remove-item"
                                                    data-id="{{ $id }}">Hapus</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <p>Keranjang Anda kosong.</p>
            @endif
            <div class="card">
                <div class="row mt-3">
                    <div class="col">
                        <h4>Total Berat Barang</h4>
                    </div>
                    <div class="col">
                        <h4>:</h4>
                    </div>
                    <div class="form-group col-md-5">
                        <input type="number" class="form-control" name="weight" id="weight" placeholder="0" readonly>
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
                        <input type="number" class="form-control" name="total" id="total" placeholder="0" readonly>
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-block col-md-8">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const removeItemButtons = document.querySelectorAll('.remove-item');

        //Untuk menghapus item di kranjang
        removeItemButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');

                if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                    fetch(`{{ url('cart/remove') }}/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    }).then(response => {
                        if (response.ok) {
                            location.reload();
                        } else {
                            alert('Gagal menghapus item dari keranjang.');
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus item dari keranjang.');
                    });
                }
            });
        });

        // Kalkulasi berat total dan harga total
        const qtyInputs = document.querySelectorAll('.qty-input');
        const totalWeightInput = document.getElementById('weight');
        const totalPriceInput = document.getElementById('total');

        function formatRupiah(angka, prefix) {
            let number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
        }

        function calculateTotals() {
            let totalWeight = 0;
            let totalPrice = 0;

            qtyInputs.forEach(function(input) {
                const row = input.closest('tr');
                const weight = parseFloat(row.querySelector('.berat').getAttribute('data-berat'));
                const price = parseFloat(row.querySelector('.harga').getAttribute('data-harga'));
                const quantity = parseFloat(input.value);

                const subtotal = price * quantity;
                document.getElementById(`subtotal-${row.id.split('-')[2]}`).value = subtotal;
                document.getElementById(`subtotal-display-${row.id.split('-')[2]}`).innerText =
                    formatRupiah(subtotal, 'Rp');

                totalWeight += weight * quantity;
                totalPrice += subtotal;
            });

            totalWeightInput.value = totalWeight;
            totalPriceInput.value = totalPrice;
        }

        qtyInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                if (input.value < 0) {
                    input.value = 0;
                }
                calculateTotals();
            });

            // Prevent negative values via keyboard
            input.addEventListener('keydown', function(e) {
                if (e.key === '-' || e.key === 'e') {
                    e.preventDefault();
                }
            });
        });

        calculateTotals();
    });

    document.addEventListener('DOMContentLoaded', function() {
        const qtyInputs = document.querySelectorAll('.qty-input');

        function validateInput(input) {
            const max = parseInt(input.getAttribute('max'), 10);
            if (input.value > max) {
                input.value = max;
            }
            if (input.value < 1) {
                input.value = 1;
            }
        }

        qtyInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                validateInput(input);
                calculateTotals(); // Update totals after validation
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === '-' || e.key === 'e') {
                    e.preventDefault();
                }
            });
        });

        function calculateTotals() {
            // Implement your total calculation logic here
        }

        // Initial validation
        qtyInputs.forEach(function(input) {
            validateInput(input);
        });
    });
</script>
