<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->id !== 1) {
            return redirect('/unauthorized');
        }

        $keywords = $request->keywords;
        $inline = 5;

        $query = User::query();

        if ($keywords) {
            $query->where(function ($query) use ($keywords) {
                if (preg_match('/^\d{4}$/', $keywords)) {
                    $query->whereYear('created_at', '=', $keywords);
                }
                elseif (preg_match('/^\d{4}-\d{2}$/', $keywords)) {
                    $query->whereYear('created_at', '=', substr($keywords, 0, 4))
                        ->whereMonth('created_at', '=', substr($keywords, 5, 2));
                }
                elseif (preg_match('/^\d{2}-\d{2}-\d{4}$/', $keywords)) {
                    $formattedDate = \Carbon\Carbon::createFromFormat('d-m-Y', $keywords)->format('Y-m-d');
                    $query->whereDate('created_at', '=', $formattedDate);
                }
                else {
                    $query->where('id', 'like', "%$keywords%")
                        ->orWhere('name', 'like', "%$keywords%")
                        ->orWhere('email', 'like', "%$keywords%")
                        ->orWhere('phone', 'like', "%$keywords%")
                        ->orWhere('created_at', 'like', "%$keywords%");
                }
            });
        }

        $data = $query->orderBy('id', 'desc')->paginate($inline);

        return view('owner.data_pelanggan', [
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function profileIndex()
    {
        return view('profile.index');
    }

    public function profileEdit()
    {
        return view('profile.edit');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
            'alamat' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->alamat = $request->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
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
