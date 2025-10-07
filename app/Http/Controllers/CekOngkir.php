<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CekOngkirController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'key' => '53708e5b423e3a8a805094c70a8efdc1'
        ])->get('https://api.rajaongkir.com/starter/city');

        $cities = $response['rajaongkir']['results'];
        $cart = session()->get('cart',[]);
        return view(
            'ecommerce.cek_ongkir',
            [
                'cities' => $cities,
                'ongkir' => '',
                'kategori'  => Kategori::All(),
            ]
        );
    }
    public function cekOngkir(Request $request)
    {
        $request->validate([
            'street'        => 'required',
            'destination'   => 'required',
            'weight'        => 'required',
            'courier'       => 'required',
        ]);
        $response = Http::withHeaders([
            'key' => '53708e5b423e3a8a805094c70a8efdc1'
        ])->get('https://api.rajaongkir.com/starter/city');

        $responseCost = Http::withHeaders([
            'key' => '53708e5b423e3a8a805094c70a8efdc1'
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin'        => '433',
            'destination'   => $request->destination,
            'weight'        => $request->weight,
            'courier'       => $request->courier,
        ]);

        $data = [
            'street'        => $request->street,
            'destination'   => $request->destination,
            'weight'        => $request->weight,
            'courier'       => $request->courier,
        ];

        $cities = $response['rajaongkir']['results'];
        $ongkir = $responseCost['rajaongkir'];
        // dd($ongkir);
        return view(
            'ecommerce.cek_ongkir',
            [
                'cities' => $cities,
                'ongkir' => $ongkir,
                'kategori'  => Kategori::All(),
                'data' => $data,
            ]
        );
    }
}
