<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $reqsearch = $request->get('search');
        $produkdb = Produk::leftJoin('kategori', 'produk.id_kategori', '=', 'kategori.id')
            ->select('kategori.name', 'produk.*');
        $data = [
            'title'     => 'Toko Zulaikha',
            'kategori'  => Kategori::All(),
            'produk'    => $produkdb->latest()->paginate(8),
        ];
        return view('ecommerce.home', $data);
    }

    public function kategori(Request $request, $id)
    {
        $edit = Kategori::findOrFail($id);
        $produkdb = Produk::leftJoin('kategori','produk.id_kategori','=','kategori.id')
                    ->select('kategori.name','produk.*')->where('produk.id_kategori', $id);
        $data = [
            'title'     => $edit->name,
            'kategori'  => Kategori::All(),
            'produk'    => $produkdb->latest()->paginate(8),
        ];
        return view('ecommerce.kategori', $data);
    }

    public function produk(Request $request, $id)
    {
        $reqsearch = $request->get('keywords');
        $produkdb = Produk::leftJoin('kategori', 'produk.id_kategori', '=', 'kategori.id')
            ->select('kategori.name', 'produk.*')->where('produk.id', $id)->first();

        if (!$produkdb) {
            abort('404');
        }

        $data = [
            'title'     => $produkdb->nama_produk,
            'kategori'  => Kategori::All(),
            'profil_toko' => User::find(1),
            'edit'      => $produkdb,
        ];
        return view('ecommerce.produk', $data);
    }

    public function search(Request $request)
    {
        $reqsearch = $request->get('keywords');
        $produkdb = Produk::leftJoin('kategori', 'produk.id_kategori', '=', 'kategori.id')
            ->select('kategori.name', 'produk.*')
            ->when($reqsearch, function ($query, $reqsearch) {
                $search = '%' . $reqsearch . '%';
                return $query->whereRaw('name like ? or nama_produk like ?', [
                    $search, $search
                ]);
            });
        $data = [
            'title'     => $reqsearch,
            'kategori'  => Kategori::All(),
            'produk'    => $produkdb->latest()->paginate(8),
        ];
        return view('ecommerce.search', $data);
    }

    // public function transaksi(Request $request)
    // {
    //     // Jika ada permintaan cek ongkir
    //     if ($request->has('kurir')) {
    //         dd($request->all());
    //         // Validasi permintaan jika diperlukan
    //         $request->validate([
    //             'kurir' => 'required', // Memastikan bahwa kurir dipilih
    //             'kota' => 'required',
    //             'provinsi' => 'required',
    //         ]);

    //         // Tangkap nilai kurir, kota, dan provinsi dari permintaan HTTP
    //         $kurir = $request->kurir;
    //         $kotaId = $request->kota; // Menggunakan ID kota
    //         $provinsiId = $request->provinsi; // Menggunakan ID provinsi

    //         // Lakukan pengolahan data yang diperlukan, misalnya panggil API RajaOngkir, dll.
    //         // Simpan hasil cek ongkir di variabel $cekOngkir

    //         // Contoh pengisian $cekOngkir, sesuaikan dengan logika Anda
    //         $cekOngkir = RajaOngkir::ongkosKirim([
    //             'origin'        => 433,     // ID kota/kabupaten asal
    //             'destination'   => $kotaId,      // ID kota/kabupaten tujuan
    //             'weight'        => 1300,    // berat barang dalam gram
    //             'courier'       => $kurir    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
    //         ]);

    //         // Kirim data cekOngkir ke tampilan (view) bersama dengan data provinsi dan kota yang diperlukan
    //         return view('ecommerce.transaksi', [
    //             'provinsi' => $provinsiId,
    //             'kota' => $kotaId,
    //             'cekOngkir' => $cekOngkir,
    //         ]);
    //     }

    //     // Jika tidak ada permintaan cek ongkir, tampilkan halaman transaksi biasa
    //     $data = [
    //         'kategori'  => Kategori::all(),
    //         'provinsi' => RajaOngkir::provinsi()->all(),
    //         'kota' => RajaOngkir::kota()->all(),
    //     ];

    //     // Perhatikan bahwa kami menggunakan route yang sama untuk metode GET dan POST di sini
    //     return view('ecommerce.transaksi', $data);
    // }

    // public function processTransaksi(Request $request)
    // {
    //     // Validasi permintaan jika diperlukan
    //     $request->validate([
    //         'kurir' => 'required', // Memastikan bahwa kurir dipilih
    //         'kota' => 'required',
    //         'provinsi' => 'required',
    //     ]);

    //     // Tangkap nilai kurir, kota, dan provinsi dari permintaan HTTP
    //     $kurir = $request->kurir;
    //     $kotaId = $request->kota; // Menggunakan ID kota
    //     $provinsiId = $request->provinsi; // Menggunakan ID provinsi

    //     // Lakukan pengolahan data yang diperlukan, misalnya panggil API RajaOngkir, dll.
    //     // Simpan hasil cek ongkir di variabel $cekOngkir

    //     // Contoh pengisian $cekOngkir, sesuaikan dengan logika Anda
    //     $cekOngkir = RajaOngkir::ongkosKirim([
    //         'origin'        => 433,     // ID kota/kabupaten asal
    //         'destination'   => $kotaId,      // ID kota/kabupaten tujuan
    //         'weight'        => 1300,    // berat barang dalam gram
    //         'courier'       => $kurir    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
    //     ]);

    //     // Kirim data cekOngkir ke tampilan (view) bersama dengan data provinsi dan kota yang diperlukan
    //     return view('ecommerce.transaksi', [
    //         'provinsi' => $provinsiId,
    //         'kota' => $kotaId,
    //         'cekOngkir' => $cekOngkir,
    //     ]);
    // }


    // public function cekOngkir(Request $request)
    // {
    //     // dd($request->all());
    //     // Validasi permintaan jika diperlukan
    //     $request->validate([
    //         'kurir' => 'required', // Memastikan bahwa kurir dipilih
    //         'kota' => 'required',
    //         'provinsi' => 'required',
    //     ]);

    //     // Tangkap nilai kurir, kota, dan provinsi dari permintaan HTTP
    //     $kurir = $request->kurir;
    //     $kotaId = $request->kota; // Menggunakan ID kota
    //     $provinsiId = $request->provinsi; // Menggunakan ID provinsi

    //     // Lakukan pengolahan data yang diperlukan, misalnya panggil API RajaOngkir, dll.

    //     // Kemudian kirimkan data hasil pengolahan ke tampilan (view)
    //     return view('ecommerce.transaksi', [
    //         'kurir' => $kurir,
    //         'kotaId' => $kotaId,
    //         'provinsiId' => $provinsiId,
    //     ]);
    // }
}
