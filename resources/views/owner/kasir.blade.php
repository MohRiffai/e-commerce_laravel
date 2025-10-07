<x-app-layout>
    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                {{ __('Kasir') }}
            </h2>
        </x-slot>
        <div class="container mt-4">
            <div class="row">
                <!-- Daftar Produk -->
                <div class="col-md-7">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title">Produk</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <form class="d-flex" action="" method="GET">
                                        <div class="input-group">
                                            <input class="form-control" type="search" name="keywords" placeholder="Cari Produk..." aria-label="Search">
                                            <button class="btn btn-outline-secondary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row" id="produkList">
                                @forelse ($data as $r)
                                    <div class="col-sm-4 mb-3">
                                        <div class="card-product @if ($r->stok_offline == 0) out-of-stock @endif"
                                            @if ($r->stok > 0) onclick="addToCart('{{ $r->id }}', '{{ $r->nama_produk }}', {{ $r->harga_jual }}, '{{ asset('storage/gambar/' . $r->gambar) }}', {{ $r->stok_offline }})" @endif>
                                            <img src="{{ asset('storage/gambar/' . $r->gambar) }}" class="img-fluid">
                                            <div class="text-center mt-2">
                                                <strong>{{ $r->nama_produk }}</strong>
                                                <h5>Rp{{ number_format($r->harga_jual) }},-</h5>
                                                @if ($r->stok_offline == 0)
                                                    <span class="badge bg-danger">Habis</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-center">Tidak Ada Data</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Daftar Item & Pembayaran -->
                <div class="col-md-5">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title">List Item</h5>
                        </div>
                        <div class="card-body">
                            <ul id="listItem" class="list-group mb-3">
                                <!-- List items will be appended here -->
                            </ul>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <h4>Subtotal</h4>
                                        </div>
                                        <div class="col text-end">
                                            <h4>:</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="subtotal" id="subtotal" placeholder="0" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <h4>Cash</h4>
                                        </div>
                                        <div class="col text-end">
                                            <h4>:</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="cash" id="cash" placeholder="0" oninput="calculateTotal()">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <h4>Kembali</h4>
                                        </div>
                                        <div class="col text-end">
                                            <h4>:</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="change" id="change" placeholder="0" readonly>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-success btn-block col-md-12" onclick="processTransaction()">Bayar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>

<script>
    // Fungsi untuk menambahkan item ke keranjang dan menyimpannya di localStorage
    // function addToCart(id, nama, harga, gambar,stok_offline) {
    //     const listItem = document.getElementById('listItem');

    //     const item = document.createElement('li');
    //     item.className = 'list-group-item d-flex justify-content-between align-items-center';

    //     const itemContent = `
    //     <img src="${gambar}" alt="${nama}" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover;">
    //     <span>${nama}</span>
    //     <input type="number" class="form-control w-25 mx-2" name="quantity" value="1" min="1" max="${stok_offline}" onchange="updateSubtotal()" oninput="validateInput(this) required">
    //     <span class="price" data-price="${harga}">${harga}</span>
    //     <button class="btn btn-danger btn-sm" onclick="removeFromCart(this)">Hapus</button>
    //     <input type="hidden" name="productId" value="${id}"> <!-- Hidden input for product ID -->
    // `;

    //     item.innerHTML = itemContent;
    //     listItem.appendChild(item);

    //     // Simpan item ke dalam localStorage
    //     saveToLocalStorage(id, nama, harga, gambar);

    //     updateSubtotal();
    // }
    // Fungsi untuk menambahkan item ke keranjang dan menyimpannya di localStorage
    function addToCart(id, nama, harga, gambar, stok) {
        const listItem = document.getElementById('listItem');

        const item = document.createElement('li');
        item.className = 'list-group-item d-flex justify-content-between align-items-center';

        const itemContent = `
    <img src="${gambar}" alt="${nama}" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover;">
    <span>${nama}</span>
    <input type="number" class="form-control w-25 mx-2" name="quantity" value="1" min="1" max="${stok}" onchange="updateSubtotal()" oninput="validateInput(this)" required>
    <span class="price" data-price="${harga}">${harga}</span>
    <button class="btn btn-danger btn-sm" onclick="removeFromCart(this)">Hapus</button>
    <input type="hidden" name="productId" value="${id}"> <!-- Hidden input for product ID -->
    `;

        item.innerHTML = itemContent;
        listItem.appendChild(item);

        // Simpan item ke dalam localStorage
        saveToLocalStorage(id, nama, harga, gambar);

        updateSubtotal();
    }

    // Fungsi untuk menyimpan item ke dalam localStorage
    function saveToLocalStorage(id, nama, harga, gambar) {
        const cartItem = {
            id: id,
            nama: nama,
            harga: harga,
            gambar: gambar
        };

        // Ambil item yang telah disimpan sebelumnya dari localStorage
        let existingItems = localStorage.getItem('cartItems');

        // Jika tidak ada item yang disimpan sebelumnya, buat array kosong
        if (!existingItems) {
            existingItems = [];
        } else {
            existingItems = JSON.parse(existingItems);
        }

        // Tambahkan item baru ke dalam array
        existingItems.push(cartItem);

        // Simpan kembali array ke dalam localStorage
        localStorage.setItem('cartItems', JSON.stringify(existingItems));
    }

    // Fungsi untuk memuat item dari localStorage saat halaman dimuat
    window.addEventListener('load', function() {
        loadCartItems();
    });

    // Fungsi untuk memuat item dari localStorage
    function loadCartItems() {
        const listItem = document.getElementById('listItem');
        let subtotal = 0;

        // Ambil item dari localStorage
        const storedItems = localStorage.getItem('cartItems');

        if (storedItems) {
            const cartItems = JSON.parse(storedItems);

            // Tampilkan setiap item pada list item
            cartItems.forEach(cartItem => {
                const item = document.createElement('li');
                item.className = 'list-group-item d-flex justify-content-between align-items-center';

                const itemContent = `
                    <img src="${cartItem.gambar}" alt="${cartItem.nama}" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover;">
                    <span>${cartItem.nama}</span>
                    <input type="number" class="form-control w-25 mx-2" name="quantity" value="1" min="1" onchange="updateSubtotal()" oninput="validateInput(this)">
                    <span class="price" data-price="${cartItem.harga}">${cartItem.harga}</span>
                    <button class="btn btn-danger btn-sm" onclick="removeFromCart(this)">Hapus</button>
                    <input type="hidden" name="productId" value="${cartItem.id}"> <!-- Hidden input for product ID -->
                `;

                item.innerHTML = itemContent;
                listItem.appendChild(item);

                // Hitung subtotal
                subtotal += parseInt(cartItem.harga);
            });
        }

        // Tampilkan subtotal
        document.getElementById('subtotal').value = subtotal;
        calculateTotal();
    }

    function updateSubtotal() {
        const listItems = document.querySelectorAll('#listItem li');
        let subtotal = 0;

        listItems.forEach(item => {
            const quantity = item.querySelector('input[name="quantity"]').value;
            const price = item.querySelector('.price').getAttribute('data-price');

            subtotal += quantity * price;
        });

        document.getElementById('subtotal').value = subtotal;
        // calculateTotal();
        updateCashInput(subtotal);
    }

    function updateCashInput(subtotal) {
        const cashInput = document.getElementById('cash');

        // Jika subtotal masih 0, nonaktifkan input "Cash"
        if (subtotal === 0) {
            cashInput.value = ""; // Kosongkan nilai input "Cash"
            cashInput.disabled = true;
        } else {
            cashInput.disabled = false;
        }
    }

    function calculateTotal() {
        const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
        const cash = parseFloat(document.getElementById('cash').value) || 0;
        const change = cash - subtotal;

        document.getElementById('change').value = change >= 0 ? change : 0;

        if (cash <= 0) {
            // Nonaktifkan tombol "Bayar"
            document.querySelector('button[type="button"]').disabled = true;
        } else {
            // Aktifkan tombol "Bayar"
            document.querySelector('button[type="button"]').disabled = false;
        }
    }

    function removeFromCart(button) {
        const listItem = button.closest('li');
        listItem.remove();
        updateSubtotal();

        // Hapus item dari localStorage
        const productId = listItem.querySelector('input[name="productId"]').value;
        removeFromLocalStorage(productId);
    }

    function removeFromLocalStorage(productId) {
        let cartItems = localStorage.getItem('cartItems');

        if (cartItems) {
            cartItems = JSON.parse(cartItems);

            // Filter item yang akan dihapus dari localStorage
            cartItems = cartItems.filter(item => item.id !== productId);

            // Simpan kembali item yang tersisa ke dalam localStorage
            localStorage.setItem('cartItems', JSON.stringify(cartItems));
        }
    }

    // function validateInput(input) {
    //     if (input.value < 0) {
    //         input.value = 0;
    //     }
    // }

    function validateInput(input) {
        const max = parseInt(input.getAttribute('max'), 10);
        if (input.value > max) {
            input.value = max;
        }
        if (input.value < 1) {
            input.value = 1;
        }
    }

    function processTransaction() {
        const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
        const cash = parseFloat(document.getElementById('cash').value) || 0;

        // Validasi jika uang yang dimasukkan kurang dari subtotal
        if (cash < subtotal) {
            alert('Uang yang dimasukkan tidak mencukupi untuk membayar subtotal.');
            return; // Hentikan proses transaksi
        }

        const items = [];
        const listItems = document.querySelectorAll('#listItem li');

        listItems.forEach(item => {
            const productId = item.querySelector('input[name="productId"]')
                .value; // Ambil ID produk dari input tersembunyi
            const productName = item.querySelector('span').innerText;
            const quantity = item.querySelector('input[name="quantity"]').value;
            const price = item.querySelector('.price').getAttribute('data-price');

            items.push({
                product_id: productId, // Tambahkan ID produk ke dalam objek item
                product_name: productName,
                quantity: quantity,
                price: price
            });
        });

        const change = cash - subtotal;

        const data = {
            items: items,
            subtotal: subtotal,
            cash: cash,
            change: change
        };

        fetch('{{ route('transaction.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Bersihkan localStorage setelah transaksi berhasil
                    localStorage.removeItem('cartItems');

                    window.location.href = '{{ route('transaction.sukses') }}' + '?id=' + data.transaction_id;
                } else {
                    alert('Transaksi gagal. Silakan coba lagi.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
    }

    window.addEventListener('load', function() {
        const initialSubtotal = parseFloat(document.getElementById('subtotal').value) || 0;
        updateCashInput(initialSubtotal);
    });
</script>
