<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatTransaksi;
use App\Models\TransaksiKasir;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->id !== 1) {
            return redirect('/unauthorized');
        }
        // Mengambil data dari tabel RiwayatTransaksi
        $riwayatTransaksi = RiwayatTransaksi::all();

        // Mengambil data dari tabel TransaksiKasir
        $transaksiKasir = TransaksiKasir::all();

        // Menggabungkan data dari kedua tabel
        $penjualan = $riwayatTransaksi->merge($transaksiKasir)->sortByDesc('created_at');

        $totalPenjualan = 0;
        // foreach ($penjualan as $item) {
        //     if (isset($item->kembalian)) {
        //         $totalPenjualan += $item->total;
        //     } elseif (Str::contains($item->no_invoice, 'INV')) {
        //         $totalPenjualan += $item->subtotal;
        //     }
        // }

        foreach ($penjualan as $item) {
            if ($item instanceof RiwayatTransaksi && $item->status === 'success') {
                $totalPenjualan += $item->subtotal;  // Menambahkan subtotal jika status adalah 'success'
            }
            if ($item instanceof TransaksiKasir && isset($item->kembalian)) {
                $totalPenjualan += $item->total;  // Menambahkan total untuk TransaksiKasir
            }
        }

        //untuk mengeluarkan data barang terjual
        $barangTerjual = [];
        $totalItemTerjual = 0;

        // Query penjualan online
        $query1 = RiwayatTransaksi::query();
        foreach ($query1->get() as $transaksi) {
            $details = json_decode($transaksi->details, true);
            foreach ($details['items'] as $item) {
                if (!isset($barangTerjual[$item['id_produk']])) {
                    $barangTerjual[$item['id_produk']] = [
                        'nama_produk' => $item['nama_produk'],
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item['id_produk']]['terjual'] += $item['qty'];
                $totalItemTerjual += $item['qty'];
            }
        }

        // Query penjualan offline
        $query2 = TransaksiKasir::query();
        foreach ($query2->get() as $transaksi) {
            $details = json_decode($transaksi->details);
            foreach ($details as $item) {
                if (!isset($barangTerjual[$item->product_id])) {
                    $barangTerjual[$item->product_id] = [
                        'nama_produk' => $item->product_name,
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item->product_id]['terjual'] += $item->quantity;
                $totalItemTerjual += $item->quantity;
            }
        }

        // Kirim data ke view
        return view('owner.semua_penjualan', compact('penjualan', 'totalPenjualan', 'barangTerjual', 'totalItemTerjual'));
    }

    public function cekPenjualan(Request $request)
    {
        // Mendapatkan tanggal awal dan akhir dari permintaan GET
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Mengambil data penjualan berdasarkan rentang tanggal
        $riwayatTransaksi = RiwayatTransaksi::whereBetween('created_at', [$startDate, $endDate])->get();
        $transaksiKasir = TransaksiKasir::whereBetween('created_at', [$startDate, $endDate])->get();

        // Menggabungkan data dari kedua tabel
        $penjualan = $riwayatTransaksi->merge($transaksiKasir)->sortByDesc('created_at');

        // Menghitung total penjualan
        $totalPenjualan = 0;
        foreach ($penjualan as $item) {
            if ($item instanceof RiwayatTransaksi && $item->status === 'success') {
                $totalPenjualan += $item->subtotal;  // Menambahkan subtotal jika status adalah 'success'
            }
            if ($item instanceof TransaksiKasir && isset($item->kembalian)) {
                $totalPenjualan += $item->total;  // Menambahkan total untuk TransaksiKasir
            }
        }

        //untuk mengeluarkan data barang terjual
        $barangTerjual = [];
        $totalItemTerjual = 0;

        // Query penjualan online berdasarkan rentang tanggal
        $query1 = RiwayatTransaksi::whereBetween('created_at', [$startDate, $endDate])->get();
        foreach ($query1 as $transaksi) {
            $details = json_decode($transaksi->details, true);
            foreach ($details['items'] as $item) {
                if (!isset($barangTerjual[$item['id_produk']])) {
                    $barangTerjual[$item['id_produk']] = [
                        'nama_produk' => $item['nama_produk'],
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item['id_produk']]['terjual'] += $item['qty'];
                $totalItemTerjual += $item['qty'];
            }
        }

        // Query penjualan offline berdasarkan rentang tanggal
        $query2 = TransaksiKasir::whereBetween('created_at', [$startDate, $endDate])->get();
        foreach ($query2 as $transaksi) {
            $details = json_decode($transaksi->details);
            foreach ($details as $item) {
                if (!isset($barangTerjual[$item->product_id])) {
                    $barangTerjual[$item->product_id] = [
                        'nama_produk' => $item->product_name,
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item->product_id]['terjual'] += $item->quantity;
                $totalItemTerjual += $item->quantity;
            }
        }

        // Kirim data ke view
        return view('owner.semua_penjualan', compact('penjualan', 'totalPenjualan', 'barangTerjual', 'totalItemTerjual', 'startDate', 'endDate'));
    }

    public function cetakPenjualanSemuaTanggal(Request $request)
    {
        // Mendapatkan tanggal awal dan akhir dari permintaan GET
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Mengambil data penjualan berdasarkan rentang tanggal
        $riwayatTransaksi = RiwayatTransaksi::whereBetween('created_at', [$startDate, $endDate])->get();
        $transaksiKasir = TransaksiKasir::whereBetween('created_at', [$startDate, $endDate])->get();

        // Menggabungkan data dari kedua tabel
        $penjualan = $riwayatTransaksi->merge($transaksiKasir)->sortByDesc('created_at');

        // Menghitung total penjualan
        $totalPenjualan = 0;
        foreach ($penjualan as $item) {
            if ($item instanceof RiwayatTransaksi && $item->status === 'success') {
                $totalPenjualan += $item->subtotal;  // Menambahkan subtotal jika status adalah 'success'
            }
            if ($item instanceof TransaksiKasir && isset($item->kembalian)) {
                $totalPenjualan += $item->total;  // Menambahkan total untuk TransaksiKasir
            }
        }

        //untuk mengeluarkan data barang terjual
        $barangTerjual = [];
        $totalItemTerjual = 0;

        // Query penjualan online berdasarkan rentang tanggal
        $query1 = RiwayatTransaksi::whereBetween('created_at', [$startDate, $endDate])->get();
        foreach ($query1 as $transaksi) {
            $details = json_decode($transaksi->details, true);
            foreach ($details['items'] as $item) {
                if (!isset($barangTerjual[$item['id_produk']])) {
                    $barangTerjual[$item['id_produk']] = [
                        'nama_produk' => $item['nama_produk'],
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item['id_produk']]['terjual'] += $item['qty'];
                $totalItemTerjual += $item['qty'];
            }
        }

        // Query penjualan offline berdasarkan rentang tanggal
        $query2 = TransaksiKasir::whereBetween('created_at', [$startDate, $endDate])->get();
        foreach ($query2 as $transaksi) {
            $details = json_decode($transaksi->details);
            foreach ($details as $item) {
                if (!isset($barangTerjual[$item->product_id])) {
                    $barangTerjual[$item->product_id] = [
                        'nama_produk' => $item->product_name,
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item->product_id]['terjual'] += $item->quantity;
                $totalItemTerjual += $item->quantity;
            }
        }

        // Kirim data ke view
        return view('owner.cetak_laporan_penjualan_semua', compact('penjualan', 'totalPenjualan', 'barangTerjual', 'totalItemTerjual', 'startDate', 'endDate'));
    }

    public function cetakPenjualanSemua(Request $request)
    {
        // Mengambil data dari tabel RiwayatTransaksi
        $riwayatTransaksi = RiwayatTransaksi::all();

        // Mengambil data dari tabel TransaksiKasir
        $transaksiKasir = TransaksiKasir::all();

        // Menggabungkan data dari kedua tabel
        $penjualan = $riwayatTransaksi->merge($transaksiKasir)->sortByDesc('created_at');

        $totalPenjualan = 0;
        foreach ($penjualan as $item) {
            if ($item instanceof RiwayatTransaksi && $item->status === 'success') {
                $totalPenjualan += $item->subtotal;  // Menambahkan subtotal jika status adalah 'success'
            }
            if ($item instanceof TransaksiKasir && isset($item->kembalian)) {
                $totalPenjualan += $item->total;  // Menambahkan total untuk TransaksiKasir
            }
        }

        //untuk mengeluarkan data barang terjual
        $barangTerjual = [];
        $totalItemTerjual = 0;

        // Query penjualan online
        $query1 = RiwayatTransaksi::query();
        foreach ($query1->get() as $transaksi) {
            $details = json_decode($transaksi->details, true);
            foreach ($details['items'] as $item) {
                if (!isset($barangTerjual[$item['id_produk']])) {
                    $barangTerjual[$item['id_produk']] = [
                        'nama_produk' => $item['nama_produk'],
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item['id_produk']]['terjual'] += $item['qty'];
                $totalItemTerjual += $item['qty'];
            }
        }

        // Query penjualan offline
        $query2 = TransaksiKasir::query();
        foreach ($query2->get() as $transaksi) {
            $details = json_decode($transaksi->details);
            foreach ($details as $item) {
                if (!isset($barangTerjual[$item->product_id])) {
                    $barangTerjual[$item->product_id] = [
                        'nama_produk' => $item->product_name,
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item->product_id]['terjual'] += $item->quantity;
                $totalItemTerjual += $item->quantity;
            }
        }

        // Kirim data ke view
        return view('owner.cetak_laporan_penjualan_semua', compact('penjualan', 'totalPenjualan', 'barangTerjual', 'totalItemTerjual'));
    }

    //Method Transaksi Online

    public function indexOnline(Request $request)
    {
        if (Auth::user()->id !== 1) {
            return redirect('/unauthorized');
        }
        $query = RiwayatTransaksi::query();

        if ($request->has('keywords') && !empty($request->keywords)) {
            $keywords = $request->keywords;
            $query->where('no_invoice', 'like', "%{$keywords}%")
                ->orWhere('subtotal', 'like', "%{$keywords}%")
                ->orWhere('ongkir', 'like', "%{$keywords}%")
                ->orWhere('total', 'like', "%{$keywords}%")
                ->orWhere('created_at', 'like', "%{$keywords}%")
                ->orWhere('status_owner', 'like', "%{$keywords}%")
                ->orWhere('status', 'like', "%{$keywords}%");
        }

        // Menggunakan paginate untuk paginasi
        // $riwayatTransaksi = $query->paginate(10);
        $riwayatTransaksi = RiwayatTransaksi::orderBy('created_at', 'desc')->get();

        $totalPenjualanBersih = $query->where('status', 'success')->sum('subtotal');
        $totalOngkir = $query->where('status', 'success')->sum('ongkir');
        $totalPenjualanKotor = $query->where('status', 'success')->sum('total');

        $totalPenjualan = 0;
        $barangTerjual = [];
        $totalItemTerjual = 0;

        foreach ($query->get() as $transaksi) {
            $details = json_decode($transaksi->details, true);
            foreach ($details['items'] as $item) {
                if (!isset($barangTerjual[$item['id_produk']])) {
                    $barangTerjual[$item['id_produk']] = [
                        'nama_produk' => $item['nama_produk'],
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item['id_produk']]['terjual'] += $item['qty'];
                $totalItemTerjual += $item['qty'];
            }
        }

        return view('owner.online_penjualan', compact('riwayatTransaksi', 'barangTerjual', 'totalItemTerjual', 'totalPenjualanBersih', 'totalPenjualanKotor', 'totalOngkir'));
    }

    public function cekPenjualanOnline(Request $request)
    {
        $query = RiwayatTransaksi::query();

        if ($request->has('keywords') && !empty($request->keywords)) {
            $keywords = $request->keywords;
            $query->where('no_invoice', 'like', "%{$keywords}%")
                ->orWhere('subtotal', 'like', "%{$keywords}%")
                ->orWhere('ongkir', 'like', "%{$keywords}%")
                ->orWhere('total', 'like', "%{$keywords}%")
                ->orWhere('created_at', 'like', "%{$keywords}%")
                ->orWhere('status_owner', 'like', "%{$keywords}%")
                ->orWhere('status', 'like', "%{$keywords}%");
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $riwayatTransaksi = RiwayatTransaksi::orderBy('created_at', 'desc')->get();

        $totalPenjualan = 0;
        $barangTerjual = [];
        $totalItemTerjual = 0;

        foreach ($query->get() as $transaksi) {
            $details = json_decode($transaksi->details, true);
            foreach ($details['items'] as $item) {
                if (!isset($barangTerjual[$item['id_produk']])) {
                    $barangTerjual[$item['id_produk']] = [
                        'nama_produk' => $item['nama_produk'],
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item['id_produk']]['terjual'] += $item['qty'];
                $totalItemTerjual += $item['qty'];
            }
        }

        $totalPenjualanBersih = $query->where('status', 'success')->sum('subtotal');
        $totalOngkir = $query->where('status', 'success')->sum('ongkir');
        $totalPenjualanKotor = $query->where('status', 'success')->sum('total');

        return view('owner.online_penjualan', compact('riwayatTransaksi', 'barangTerjual', 'totalItemTerjual', 'totalPenjualanBersih', 'totalPenjualanKotor', 'totalOngkir', 'startDate', 'endDate'));
    }

    public function cetakPenjualanOnline(Request $request)
    {
        $query = RiwayatTransaksi::query();

        if ($request->has('keywords') && !empty($request->keywords)) {
            $keywords = $request->keywords;
            $query->where('no_invoice', 'like', "%{$keywords}%")
                ->orWhere('subtotal', 'like', "%{$keywords}%")
                ->orWhere('ongkir', 'like', "%{$keywords}%")
                ->orWhere('total', 'like', "%{$keywords}%")
                ->orWhere('created_at', 'like', "%{$keywords}%")
                ->orWhere('status_owner', 'like', "%{$keywords}%")
                ->orWhere('status', 'like', "%{$keywords}%");
        }

        $riwayatTransaksi = RiwayatTransaksi::orderBy('created_at', 'desc')->get();

        $totalPenjualan = 0;
        $barangTerjual = [];
        $totalItemTerjual = 0;

        foreach ($query->get() as $transaksi) {
            $details = json_decode($transaksi->details, true);
            foreach ($details['items'] as $item) {
                if (!isset($barangTerjual[$item['id_produk']])) {
                    $barangTerjual[$item['id_produk']] = [
                        'nama_produk' => $item['nama_produk'],
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item['id_produk']]['terjual'] += $item['qty'];
                $totalItemTerjual += $item['qty'];
            }
        }

        $totalPenjualanBersih = $query->where('status', 'success')->sum('subtotal');
        $totalOngkir = $query->where('status', 'success')->sum('ongkir');
        $totalPenjualanKotor = $query->where('status', 'success')->sum('total');

        return view('owner.cetak_laporan_penjualan_online_semua', compact('riwayatTransaksi', 'barangTerjual', 'totalItemTerjual', 'totalPenjualanBersih', 'totalPenjualanKotor', 'totalOngkir'));
    }

    public function cetakPenjualanOnlineTanggal(Request $request)
    {
        $query = RiwayatTransaksi::query();

        if ($request->has('keywords') && !empty($request->keywords)) {
            $keywords = $request->keywords;
            $query->where('no_invoice', 'like', "%{$keywords}%")
                ->orWhere('subtotal', 'like', "%{$keywords}%")
                ->orWhere('ongkir', 'like', "%{$keywords}%")
                ->orWhere('total', 'like', "%{$keywords}%")
                ->orWhere('created_at', 'like', "%{$keywords}%")
                ->orWhere('status_owner', 'like', "%{$keywords}%")
                ->orWhere('status', 'like', "%{$keywords}%");
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $riwayatTransaksi = RiwayatTransaksi::orderBy('created_at', 'desc')->get();

        $totalPenjualan = 0;
        $barangTerjual = [];
        $totalItemTerjual = 0;

        foreach ($query->get() as $transaksi) {
            $details = json_decode($transaksi->details, true);
            foreach ($details['items'] as $item) {
                if (!isset($barangTerjual[$item['id_produk']])) {
                    $barangTerjual[$item['id_produk']] = [
                        'nama_produk' => $item['nama_produk'],
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item['id_produk']]['terjual'] += $item['qty'];
                $totalItemTerjual += $item['qty'];
            }
        }

        $totalPenjualanBersih = $query->where('status', 'success')->sum('subtotal');
        $totalOngkir = $query->where('status', 'success')->sum('ongkir');
        $totalPenjualanKotor = $query->where('status', 'success')->sum('total');

        return view('owner.cetak_laporan_penjualan_online_semua', compact('riwayatTransaksi', 'barangTerjual', 'totalItemTerjual', 'totalPenjualanBersih', 'totalPenjualanKotor', 'totalOngkir', 'startDate', 'endDate'));
    }

    public function tampilInvoiceOnline($id)
    {
        $transaksi = RiwayatTransaksi::findOrFail($id);

        $details = json_decode($transaksi->details, true);

        // Ambil data yang diperlukan untuk invoice
        $data = [
            'transaksi' => $transaksi,
            'details'   => $details,
        ];

        return view('owner.invoice_online', $data);
    }

    public function updateStatusOwner(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'status_owner' => 'required|string',
        ]);

        // Temukan transaksi berdasarkan id
        $transaksi = RiwayatTransaksi::findOrFail($id);

        // Update status owner
        $transaksi->status_owner = $request->status_owner;
        $transaksi->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Status Owner berhasil diperbarui');
    }

    // Method Penjualan Offline 

    public function indexOffline(Request $request)
    {
        if (Auth::user()->id !== 1) {
            return redirect('/unauthorized');
        }
        $query = TransaksiKasir::query();

        if ($request->has('keywords') && !empty($request->keywords)) {
            $keywords = $request->keywords;
            $query->where('no_nota', 'like', "%{$keywords}%")
                ->orWhere('total', 'like', "%{$keywords}%")
                ->orWhere('created_at', 'like', "%{$keywords}%");
        }

        // Menggunakan paginate untuk paginasi
        $riwayatTransaksi = TransaksiKasir::orderBy('created_at', 'desc')->get();

        $totalPenjualan = 0;
        $barangTerjual = [];
        $totalItemTerjual = 0;

        foreach ($query->get() as $transaksi) {
            foreach (json_decode($transaksi->details) as $item) {
                if (!isset($barangTerjual[$item->product_id])) {
                    $barangTerjual[$item->product_id] = [
                        'nama_produk' => $item->product_name,
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item->product_id]['terjual'] += $item->quantity;
                $totalItemTerjual += $item->quantity;
            }
        }

        $totalPenjualan = $query->sum('total');

        return view('owner.offline_penjualan', compact('riwayatTransaksi', 'barangTerjual', 'totalItemTerjual', 'totalPenjualan'));
    }

    public function cekPenjualanOffline(Request $request)
    {
        $query = TransaksiKasir::query();

        if ($request->has('keywords') && !empty($request->keywords)) {
            $keywords = $request->keywords;
            $query->where('no_nota', 'like', "%{$keywords}%")
                ->orWhere('total', 'like', "%{$keywords}%")
                ->orWhere('created_at', 'like', "%{$keywords}%");
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $riwayatTransaksi = TransaksiKasir::orderBy('created_at', 'desc')->get();

        $barangTerjual = [];
        $totalItemTerjual = 0;

        foreach ($query->get() as $transaksi) {
            foreach (json_decode($transaksi->details) as $item) {
                if (!isset($barangTerjual[$item->product_id])) {
                    $barangTerjual[$item->product_id] = [
                        'nama_produk' => $item->product_name,
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item->product_id]['terjual'] += $item->quantity;
                $totalItemTerjual += $item->quantity;
            }
        }

        $totalPenjualan = $query->sum('total');

        return view('owner.offline_penjualan', compact('riwayatTransaksi', 'barangTerjual', 'totalItemTerjual', 'totalPenjualan', 'startDate', 'endDate'));
    }

    public function cetakPenjualanOffline(Request $request)
    {
        $query = TransaksiKasir::query();

        if ($request->has('keywords') && !empty($request->keywords)) {
            $keywords = $request->keywords;
            $query->where('no_nota', 'like', "%{$keywords}%")
                ->orWhere('total', 'like', "%{$keywords}%")
                ->orWhere('created_at', 'like', "%{$keywords}%");
        }

        $riwayatTransaksi = TransaksiKasir::orderBy('created_at', 'desc')->get();

        $totalPenjualan = 0;
        $barangTerjual = [];
        $totalItemTerjual = 0;

        foreach ($query->get() as $transaksi) {
            foreach (json_decode($transaksi->details) as $item) {
                if (!isset($barangTerjual[$item->product_id])) {
                    $barangTerjual[$item->product_id] = [
                        'nama_produk' => $item->product_name,
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item->product_id]['terjual'] += $item->quantity;
                $totalItemTerjual += $item->quantity;
            }
        }

        $totalPenjualan = $query->sum('total');

        return view('owner.cetak_laporan_penjualan_offline_semua', compact('riwayatTransaksi', 'barangTerjual', 'totalItemTerjual', 'totalPenjualan'));
    }

    public function cetakPenjualanOfflineTanggal(Request $request)
    {
        $query = TransaksiKasir::query();

        if ($request->has('keywords') && !empty($request->keywords)) {
            $keywords = $request->keywords;
            $query->where('no_nota', 'like', "%{$keywords}%")
                ->orWhere('total', 'like', "%{$keywords}%")
                ->orWhere('created_at', 'like', "%{$keywords}%");
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $riwayatTransaksi = TransaksiKasir::orderBy('created_at', 'desc')->get();

        $barangTerjual = [];
        $totalItemTerjual = 0;

        foreach ($query->get() as $transaksi) {
            foreach (json_decode($transaksi->details) as $item) {
                if (!isset($barangTerjual[$item->product_id])) {
                    $barangTerjual[$item->product_id] = [
                        'nama_produk' => $item->product_name,
                        'terjual' => 0
                    ];
                }
                $barangTerjual[$item->product_id]['terjual'] += $item->quantity;
                $totalItemTerjual += $item->quantity;
            }
        }

        $totalPenjualan = $query->sum('total');

        return view('owner.cetak_laporan_penjualan_offline_semua', compact('riwayatTransaksi', 'barangTerjual', 'totalItemTerjual', 'totalPenjualan', 'startDate', 'endDate'));
    }

    public function nota($id)
    {
        $transaction = TransaksiKasir::findOrFail($id);
        return view('owner.nota', compact('transaction'));
    }
}
