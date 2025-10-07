<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\RiwayatTransaksi;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class KeranjangController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        if ($userId == 1) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $cart = session()->get('cart', []);
        return view('ecommerce.keranjang', [
            'cart' => $cart,
            'kategori' => Kategori::All()
        ]);
    }

    // public function add(Request $request, $id)
    // {
    //     $product = [
    //         'id' => $request->id,
    //         'nama_produk' => $request->nama_produk,
    //         'harga_produk' => $request->harga_produk,
    //         'berat' => $request->berat,
    //         'gambar' => $request->gambar,
    //     ];

    //     //ambil session caert atau buat array nya jika tidak ada
    //     $cart = session()->get('cart', []);

    //     //tambah produk ke cart
    //     $cart[$id] = $product;

    //     //simpan cart ke session
    //     session()->put('cart', $cart);

    //     return redirect()->route('cart.index');
    // }



    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json(['success' => true]);
    }

    // public function checkout(Request $request)
    // {
    //     // Retrieve cart from session
    //     $cart = session()->get('cart');
    //     if (!$cart) {
    //         return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
    //     }

    //     // Clear the cart session
    //     session()->forget('cart');

    //     // Save each item in the cart to the database
    //     foreach ($cart as $item) {
    //         RiwayatTransaksi::create([
    //             'id_user'       => auth()->user()->id, // Pastikan user telah terautentikasi
    //             'id_produk'     => $item['id'],
    //             'gambar'        => $item['gambar'],
    //             'nama_produk'   => $item['nama_produk'],
    //             'qty'           => $request->qty,
    //             'total_berat'   => $request->weight, // Menggunakan nilai dari input weight
    //             'subtotal'      => $request->total // Menggunakan nilai dari input total
    //         ]);
    //     }

    //     // Redirect to the transaction history page
    //     return redirect()->route('riwayat_transaksi.index')->with('success', 'Transaksi berhasil disimpan.');
    // }

    public function add(Request $request, $id)
    {
        // Ambil stok dari database
        $product = Produk::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Ambil jumlah produk dalam keranjang (jika ada)
        $cart = session()->get('cart', []);
        $existingQty = isset($cart[$id]) ? $cart[$id]['qty'] : 0;

        // Cek apakah total qty yang diminta melebihi stok
        $requestedQty = 1; // Karena ini adalah penambahan satu unit per klik
        $totalQty = $existingQty + $requestedQty;

        if ($totalQty > $product->stok) {
            return redirect()->back()->with('error', 'Jumlah produk melebihi stok yang tersedia.');
        }

        // Tambahkan produk ke cart
        $cart[$id] = [
            "id" => $product->id,
            "nama_produk" => $product->nama_produk,
            "harga_produk" => $product->harga_jual,
            "berat" => $product->berat,
            "gambar" => asset('storage/gambar/' . $product->gambar),
            "qty" => $totalQty,
            "stok" => $product->stok,
        ];

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function checkout(Request $request)
    {
        // Retrieve cart from session
        $cart = session()->get('cart');
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        // Prepare details data
        $details = [];
        foreach ($cart as $id => $item) {
            $details[] = [
                'id_produk'         => $item['id'],
                'harga_produk'      => $item['harga_produk'],
                'gambar'            => $item['gambar'],
                'nama_produk'       => $item['nama_produk'],
                'qty'               => $request->input("qty.$id"), // Retrieve qty per item using the correct key
                'subtotal'          => $request->input("subtotal.$id"),
            ];
        }

        // Save initial transaction to the database to get the ID
        $transaction = RiwayatTransaksi::create([
            'id_user'           => auth()->user()->id,
            'total_berat'       => $request->weight,
            'subtotal'          => $request->total,
            'status_owner'      => 'pending',
            'status'            => 'pending',
            'status_transaksi'  => 'BELUM LUNAS',
            'details'           => json_encode(['items' => $details]),
        ]);

        // Generate purchase order code
        $date = date('Ymd'); // Format tanggal YYYYMMDD
        $userId = auth()->user()->id;
        $transactionId = $transaction->id; // Get the transaction ID
        $orderId = strtoupper('ORD/' . $date . '/' . 'ZLKH/' . $transactionId . $userId);

        // Update transaction with the purchase order code
        $transaction->order_id = $orderId;
        $transaction->save();

        // Clear the cart session
        session()->forget('cart');

        return redirect()->route('riwayat_transaksi.index');
    }
}
