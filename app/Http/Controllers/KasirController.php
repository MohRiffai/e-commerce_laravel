<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\TransaksiKasir;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Produk $produk)
    {
        if (Auth::user()->id !== 1) {
            return redirect('/unauthorized');
        }
        $keywords = $request->keywords;
        // $inline = 20;

        $query = Produk::query();

        if ($keywords) {
            $query->where('id', 'like', "%$keywords%")
                ->orWhere('nama_produk', 'like', "%$keywords%")
                ->orWhereHas('kategori', function ($query) use ($keywords) {
                    $query->where('name', 'like', "%$keywords%");
                });
        }

        // $data = $query->orderBy('id', 'desc')->paginate($inline);
        $data = $query->orderBy('id', 'desc')->get();

        return view('owner.kasir', [
            'kategori' => Kategori::all(),
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $tanggalSekarang = date('Y-m-d');
        $nomorNota = 'KSR/' . 'ZLKH/' . $tanggalSekarang . '-' . uniqid();

        $transaction = TransaksiKasir::create([
            'no_nota' => $nomorNota,
            'details' => json_encode($data['items']),
            'total' => $data['subtotal'],
            'cash' => $data['cash'],
            'kembalian' => $data['change'],
        ]);

        // Kurangi stok untuk setiap produk yang dibeli
        foreach ($data['items'] as $item) {
            $product = Produk::find($item['product_id']); // Mengambil produk berdasarkan ID
            if ($product) {
                $product->stok_offline -= $item['quantity']; // Mengurangi stok berdasarkan jumlah yang dibeli
                $product->save(); // Menyimpan perubahan ke database
            }
        }

        return response()->json(['success' => true, 'transaction_id' => $transaction->id]); // Return JSON response with transaction ID
    }


    public function success()
    {
        return view('owner.success');
    }

    public function nota($id)
    {
        $transaction = TransaksiKasir::findOrFail($id);
        return view('owner.nota', compact('transaction'));
    }

    // public function cetakNota($id)
    // {
    //     $transaction = TransaksiKasir::findOrFail($id);
    //     // Logika untuk mencetak nota, misalnya generate PDF
    //     return view('owner.cetakNota', compact('transaction'));
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
