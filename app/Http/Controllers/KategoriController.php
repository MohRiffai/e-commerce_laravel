<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request, Kategori $kategori)
    {
        if (Auth::user()->id !== 1) {
            return redirect('/unauthorized');
        }
        // $this->authorize('viewAny', $category);
        $keywords = $request->keywords;
        $inline = 3;
        if (strlen($keywords)) {
            $data = kategori::where('id', 'like', "%$keywords%")
                ->orWhere('name', 'like', "%$keywords%")
                ->paginate($inline);
        } else {
            $data = kategori::orderBy('id', 'desc')->paginate($inline);
        }
        return view(view: 'owner.kategori')->with('data', $data);
    }

    public function show(kategori $kategori)
    {
        //
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        $edit = Kategori::findOrFail($id);

        return view('owner.edit_kategori', ['edit' => $edit]);
    }


    public function update(Request $request)
    {
        if (Auth::user()->id !== 1) {
            return redirect('/unauthorized');
        }
        $request->validate([
            'name' => 'required',
        ]);

        $kategori = Kategori::findOrFail($request->id);

        $kategori->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with("success", "Berhasil Update Data Kategori " . $request->name . ' !');
    }

    public function store(Request $request)
    {
        if (Auth::user()->id !== 1) {
            return redirect('/unauthorized');
        }
        $request->validate([
            'name' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'created_at' => now(),
        ];

        Kategori::create($data);

        return redirect()->back()->with('success', 'Berhasil Insert Data!');
    }

    public function destroy(kategori $kategori)
    {
        if (Auth::user()->id !== 1) {
            return redirect('/unauthorized');
        }
        $kategori->delete();

        return redirect()->to('kategori')->with('success', 'Berhasil Hapus Data Kategori !');
    }
}
