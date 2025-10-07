<?php

namespace App\Http\Controllers;

use App\Models\RiwayatTransaksi;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RiwayatTransaksiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request, RiwayatTransaksi $riwayattransaksi)
    {
        if (Auth::user()->id === 1) {
            return redirect('/unauthorized');
        }
        $userId = Auth::id(); // Mendapatkan ID pengguna yang sedang login
        $keywords = $request->keywords;
        $inline = 5;

        if (strlen($keywords)) {
            // Jika ada kata kunci pencarian, kita akan mencari data berdasarkan kata kunci
            $data = RiwayatTransaksi::where('id_user', $userId)
                ->where(function ($query) use ($keywords) {
                    $query->where('id', 'like', "%$keywords%")
                        ->orWhere('no_invoice', 'like', "%$keywords%")
                        ->orWhere('order_id', 'like', "%$keywords%");
                })
                ->orderBy('id', 'desc')
                ->paginate($inline);
        } else {
            // Jika tidak ada kata kunci pencarian, kita akan menampilkan semua riwayat transaksi untuk pengguna yang sedang login
            $data = RiwayatTransaksi::where('id_user', $userId)
                ->orderBy('id', 'desc')
                ->paginate($inline);
        }
        return view(view: 'pelanggan.riwayat_transaksi')->with('data', $data);
    }

    public function showInputAlamat($id)
    {
        $response = Http::withHeaders([
            'key' => '53708e5b423e3a8a805094c70a8efdc1'
        ])->get('https://api.rajaongkir.com/starter/city');

        $riwayatTransaksi = RiwayatTransaksi::find($id);
        if (!$riwayatTransaksi) {
            return redirect()->back()->with('error', 'Riwayat transaksi tidak ditemukan.');
        }

        $cities = $response['rajaongkir']['results'];

        return view('ecommerce.alamat', [
            'riwayatTransaksi' => $riwayatTransaksi,
            'kategori' => Kategori::all(),
            'cities' => $cities
        ]);
    }

    public function simpanAlamat(Request $request)
    {
        $request->validate([
            'street'        => 'required',
            'destination'   => 'required',
            'courier'       => 'required',
        ]);

        $riwayatTransaksi = RiwayatTransaksi::find($request->riwayat_transaksi_id);
        if (!$riwayatTransaksi) {
            return redirect()->back()->with('error', 'Riwayat transaksi tidak ditemukan.');
        }

        $riwayatTransaksi->update([
            'alamat'    => $request->street,
            'destination' => $request->destination,
            'courier' => $request->courier
        ]);

        return redirect()->route('riwayat_transaksi.index')->with('success', 'Alamat berhasil disimpan.');
    }


    public function cekOngkir($id)
    {
        $riwayatTransaksii = RiwayatTransaksi::with('user')->findOrFail($id);
        $riwayatTransaksi = RiwayatTransaksi::find($id);
        if (!$riwayatTransaksi) {
            return redirect()->back()->with('error', 'Riwayat transaksi tidak ditemukan.');
        }

        if (!$riwayatTransaksi) {
            return redirect()->back()->with('error', 'Riwayat transaksi tidak ditemukan.');
        }

        $response = Http::withHeaders([
            'key' => '53708e5b423e3a8a805094c70a8efdc1'
        ])->get('https://api.rajaongkir.com/starter/city');

        $responseCost = Http::withHeaders([
            'key' => '53708e5b423e3a8a805094c70a8efdc1'
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => '433',
            'destination' => $riwayatTransaksi->destination,
            'weight' => $riwayatTransaksi->total_berat,
            'courier' => $riwayatTransaksi->courier,
        ]);

        if ($responseCost->successful()) {
            $ongkir = $responseCost['rajaongkir'];
        } else {
            return redirect()->back()->with('error', 'Gagal mengambil data ongkir dari RajaOngkir.');
        }

        $cities = $response['rajaongkir']['results'];

        $kategori = Kategori::all();

        return view('ecommerce.cek_ongkir', [
            'ongkir'            => $ongkir,
            'kategori'          => $kategori,
            'riwayatTransaksi'  => $riwayatTransaksi,
            'riwayatTransaksii' => $riwayatTransaksii,
            'cities'            => $cities,
        ]);
    }

    public function simpanOngkridanTotal(Request $request)
    {
        // Validasi data jika diperlukan
        $request->validate([
            'ongkir'        => 'required|numeric',
            'alamat_kirim'  => 'required|string',
            'jasa_kurir'    => 'required|string',
            'service'       => 'required|string',
            'est_kirim'     => 'required|string',
            'total'         => 'required|numeric',
        ]);

        $riwayatTransaksi = RiwayatTransaksi::find($request->riwayat_transaksi_id);
        if (!$riwayatTransaksi) {
            return redirect()->back()->with('error', 'Riwayat transaksi tidak ditemukan.');
        }

        $details = json_decode($riwayatTransaksi->details, true);

        $riwayatTransaksi->update([
            'ongkir'        => $request->ongkir,
            'alamat_kirim'  => $request->alamat_kirim,
            'jasa_kurir'    => $request->jasa_kurir,
            'service'       => $request->service,
            'est_kirim'     => $request->est_kirim,
            'total'         => $request->total,

        ]);

        //buat cetak snap_token Midtrans

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        // $itemDetails = [];
        // foreach ($details['items'] as $detail) {
        //     $itemDetails[] = [
        //         'id'       => $detail['id_produk'],
        //         'price'    => $detail['harga_produk'],
        //         'quantity' => $detail['qty'],
        //         'name'     => $detail['nama_produk'],
        //     ];
        // }

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $request->total,
            ),

            // Apabila item_details di isi, maka gross_mount akan diabaikan dan jumlah
            // bayar yang muncul di snap akan menjadi total harga produk (subtotal) di item_details 
            // 'item_details' => $itemDetails, 

            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            )
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $auth = base64_encode(env('MIDTRANS_SERVER_KEY'));

        $response = Http::withHeaders([
            'Authorization' => "Basic $auth",
        ])->withOptions([
            'verify' => false, // Nonaktifkan verifikasi sertifikat
        ])->post('https://app.sandbox.midtrans.com/snap/v1/transaction', $params);

        //
        // start untuk pembuatan nomor invoice
        // order id dari midtrans
        $midtrans_order_id = $params['transaction_details']['order_id'];

        // buat tanggal saat ini (contoh format: tahun/bulan/tanggal)
        $current_date = date('Ymd');

        // buat ID transaksi (misal dari model RiwayatTransaksi)
        $transaction_id = $riwayatTransaksi->id;

        // buat ID pengguna (misal ID pengguna yang saat ini login)
        $user_id = Auth::id();

        // disatukan jadi satu untuk buat nomor invoice
        $invoice_number = 'INV/' . $current_date . '/' . 'ZLKH/' . $transaction_id . $user_id . '/' . $midtrans_order_id;

        // simpan nomor invoice ke DB RiwayatTransaksi
        $riwayatTransaksi->no_invoice = $invoice_number;
        // end pembuatan nomor invoice
        //

        // untuk buat snap token midtrnas dan disimpan di DB RiwayatTransaksi
        $riwayatTransaksi->snap_token = $snapToken;
        $riwayatTransaksi->save();

        // Redirect atau kembalikan respon yang sesuai
        return redirect()->route('riwayat_transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function showTransaction($id)
    {
        // Ambil transaksi berdasarkan ID
        $riwayattransaction = RiwayatTransaksi::with('user')->find($id);

        // Decode JSON details menjadi array
        $details = json_decode($riwayattransaction->details, true);

        $kategori = Kategori::all();

        return view('ecommerce.checkout', compact('riwayattransaction', 'details', 'kategori',));
    }

    public function success($id)
    {
        $riwayattransaction = RiwayatTransaksi::with('user')->find($id);

        // Konversi details menjadi array
        $details = json_decode($riwayattransaction->details, true);

        // Ubah status transaksi menjadi 'success'
        $riwayattransaction->status = 'success';
        $riwayattransaction->status_transaksi = 'LUNAS';
        $riwayattransaction->save();

        // Iterasi setiap detail transaksi
        foreach ($details['items'] as $detail) {
            $produk = Produk::find($detail['id_produk']);

            // Periksa apakah produk ditemukan
            if ($produk) {
                // Kurangi stok produk dengan jumlah yang dibeli
                $produk->stok -= $detail['qty'];
                // Simpan perubahan stok produk
                $produk->save();
            }
        }

        $user = $riwayattransaction->user;
        if ($user) {
            $user->alamat = $riwayattransaction->alamat; // Atau sesuaikan dengan field alamat yang sesuai
            $user->save();
        }

        // Ambil kategori produk untuk digunakan di view
        $kategori = Kategori::all();

        // Kirim data ke view
        return view('ecommerce.transaksi_berhasil', compact('riwayattransaction', 'kategori'));
    }

    public function tampilInvoice($id)
    {
        $transaksi = RiwayatTransaksi::findOrFail($id);

        $details = json_decode($transaksi->details, true);

        // Ambil data yang diperlukan untuk invoice
        $data = [
            'transaksi' => $transaksi,
            'details'   => $details,
        ];

        return view('ecommerce.invoice', $data);
    }

    public function downloadInvoice($id)
    {
        $transaksi = RiwayatTransaksi::findOrFail($id)->all();

        $details = json_decode($transaksi->details, true);

        // Ambil data yang diperlukan untuk invoice
        $data = [
            'transaksi' => $transaksi,
            'details'   => $details,
        ];

        return view('ecommerce.invoice', $data);
    }


    public function destroy($id)
    {
        $transaksi = riwayattransaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('riwayat_transaksi.index')->with('success', 'Transaksi berhasil dibatalkan.');
    }

    // public function cekOngkir(Request $request)
    // {
    //     // $request->validate([
    //     //     'street'        => 'required',
    //     //     'destination'   => 'required',
    //     //     'courier'       => 'required',
    //     // ]);
    //     $response = Http::withHeaders([
    //         'key' => '53708e5b423e3a8a805094c70a8efdc1'
    //     ])->get('https://api.rajaongkir.com/starter/city');

    //     $responseCost = Http::withHeaders([
    //         'key' => '53708e5b423e3a8a805094c70a8efdc1'
    //     ])->post('https://api.rajaongkir.com/starter/cost', [
    //         'origin' => '433',
    //         'destination' => '23',
    //         'weight' => '1',
    //         'courier' => 'jne',
    //     ]);

    //     $transaksi = RiwayatTransaksi::find($request->transaksi_id);

    //     // $data = [
    //     //     // 'street'        => $request->street,
    //     //     'destination'   => $request->destination,
    //     //     'weight'        => $request->weight,
    //     //     'courier'       => $request->courier,
    //     // ];

    //     $cities = $response['rajaongkir']['results'];
    //     $ongkir = $responseCost['rajaongkir'];
    //     // dd($ongkir);
    //     return view(
    //         'ecommerce.cek_ongkir',
    //         [
    //             'cities' => $cities,
    //             'ongkir' => $ongkir,
    //             'kategori'  => Kategori::All(),
    //             'transaksi' => $transaksi,
    //             // 'data' => $data,
    //         ]
    //     );
    // }
}
