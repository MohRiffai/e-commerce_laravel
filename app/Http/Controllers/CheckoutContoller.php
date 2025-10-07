<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        return view('ecommerce.cart');
    }
}
