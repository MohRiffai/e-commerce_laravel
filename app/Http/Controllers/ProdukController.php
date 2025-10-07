<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request, Produk $produk)
    {
        if (Auth::user()->id !== 1) {
            return redirect('/unauthorized');
        }
        $keywords = $request->keywords;
        $inline = 5;

        $query = Produk::query();

        if ($keywords) {
            $query->where('id', 'like', "%$keywords%")
                ->orWhere('nama_produk', 'like', "%$keywords%")
                ->orWhereHas('kategori', function ($query) use ($keywords) {
                    $query->where('name', 'like', "%$keywords%");
                });
        }

        $data = $query->orderBy('id', 'desc')->paginate($inline);

        return view('owner.produk', [
            'kategori' => Kategori::all(),
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'   => 'required',
            'gambar'        => 'required|image|max:1024',
            'nama_produk'   => 'required',
            'berat'         => 'required',
            'stok'          => 'required',
            'stok_offline'  => 'required',
            'deskripsi'     => 'required',
            'harga_jual'    => 'required',
        ]);

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $input['imagename'] = 'produk_' . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/gambar');
            $image->move($destinationPath, $input['imagename']);
        }

        Produk::create([
            'id_kategori'   => $request->id_kategori,
            'gambar'        => $input['imagename'] ?? null,
            'nama_produk'   => $request->nama_produk,
            'berat'         => $request->berat,
            'stok'          => $request->stok,
            'stok_offline'  => $request->stok_offline,
            'deskripsi'     => $request->deskripsi,
            'harga_jual'    => $request->harga_jual,
        ]);

        return redirect()->back()->with("success", "Berhasil Insert Data!");
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        $edit = Produk::findOrFail($id);
        // Tambahkan ini untuk memeriksa data yang ditemukan

        $kategori = Kategori::All();
        $data = [
            'edit' => $edit,
            'kategori' => $kategori,
        ];
        return view('owner.edit_produk', $data);
    }

    // public function update(Request $request, $id)
    // {
    //     $validator = \Validator::make($request->all(), [
    //         "id"            => "required",
    //         "id_kategori"   => "required",
    //         "nama_produk"   => "required",
    //         "deskripsi"     => "required",
    //         "harga_jual"    => "required",
    //     ]);

    //     if ($validator->passes()) {
    //         $produk = Produk::findOrFail($request->get('id'));

    //         if ($request->file('gambar')) {
    //             $validator = \Validator::make($request->all(), [
    //                 "gambar" => "required|image|max:1024",
    //             ]);
    //             if ($validator->passes()) {
    //                 $image = $request->file('gambar');
    //                 $input['imagename'] = 'produk_' . time() . '.' . $image->getClientOriginalExtension();

    //                 $destinationPath = storage_path('app/public/gambar');
    //                 $image->move($destinationPath, $input['imagename']);
    //                 $gambar = $input['imagename'];
    //             } else {
    //                 return redirect()->back()->withErrors($validator)->with("failed", " Gagal Update Data ! ");
    //             }
    //         } else {
    //             $gambar = $produk->gambar;
    //         }

    //         $produk->update([
    //             'id_kategori'   => $request->get("id_kategori"),
    //             'gambar'        => $gambar, // Pastikan variabel gambar sudah diinisialisasi dengan benar
    //             'nama_produk'   => $request->get("nama_produk"),
    //             'deskripsi'     => $request->get("deskripsi"),
    //             'harga_jual'    => $request->get("harga_jual"),
    //             'updated_at'    => date('Y-m-d H:i:s'), // Gunakan helper untuk waktu saat ini
    //         ]);

    //         return redirect()->back()->with("success", " Berhasil Update Data Produk " . $request->get("nama_produk") . ' !');
    //     } else {
    //         return redirect()->back()->withErrors($validator)->with("failed", " Gagal Update Data ! ");
    //     }
    // }
    public function update(Request $request)
    {
        $request->validate([
            "id"            => "required",
            "id_kategori"   => "required",
            "nama_produk"   => "required",
            "berat"         => "required",
            "stok"          => "required",
            'stok_offline'  => 'required',
            "deskripsi"     => "required",
            "harga_jual"    => "required",
            "gambar"        => "image|max:1024",
        ]);

        $produk = Produk::findOrFail($request->get('id'));

        if ($request->file('gambar')) {
            $image = $request->file('gambar');
            $input['imagename'] = 'produk_' . time() . '.' . $image->getClientOriginalExtension();

            $destinationPath = storage_path('app/public/gambar');
            $image->move($destinationPath, $input['imagename']);
            $gambar = $input['imagename'];
        } else {
            $gambar = $produk->gambar;
        }

        $produk->update([
            'id_kategori'   => $request->get("id_kategori"),
            'gambar'        => $gambar, // Pastikan variabel gambar sudah diinisialisasi dengan benar
            'nama_produk'   => $request->get("nama_produk"),
            'berat'         => $request->get("berat"),
            'stok'          => $request->get("stok"),
            'stok_offline'  => $request->get("stok_offline"),
            'deskripsi'     => $request->get("deskripsi"),
            'harga_jual'    => $request->get("harga_jual"),
            'updated_at'    => now(), // Gunakan helper untuk waktu saat ini
        ]);

        return redirect()->back()->with("success", " Berhasil Update Data Produk " . $request->get("nama_produk") . ' !');
    }
    public function destroy(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->back()->with("success", " Berhasil Delete Data Produk ! ");
    }
}
