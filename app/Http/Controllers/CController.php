<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class CController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = $request->only('id','gambar', 'nama_produk', 'harga_produk', 'berat');
        $cart = session()->get('cart', []);
        $cart[$product['id']] = $product;
        session()->put('cart', $cart);

        return redirect()->route('checkout.index');
    }

    public function remove($key)
    {
        $cart = session()->get('cart');

        if(isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk telah dihapus dari keranjang!');
    }
}

