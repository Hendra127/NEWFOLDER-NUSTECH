<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk manajemen file
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil user.
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * Memperbarui data profil ke database.
     */
    public function update(Request $request)
{
    $user = Auth::user();

    // 1. Validasi
    $request->validate([
        'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        // ... validasi lainnya
    ]);

    // 2. Logika Simpan ke public/assets/img/profiles
    if ($request->hasFile('photo')) {
        
        // Hapus foto lama dari folder public jika ada
        if ($user->profile_photo_path && file_exists(public_path($user->profile_photo_path))) {
            unlink(public_path($user->profile_photo_path));
        }
if ($request->hasFile('photo')) {
    $destinationPath = public_path('assets/img/profiles');

    // Cek jika folder belum ada, maka buat foldernya
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    $file = $request->file('photo');
    // ... sisa kode move file ...
}
        $file = $request->file('photo');
        $fileName = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
        
        // Tentukan path: public/assets/img/profiles
        // Fungsi ini akan otomatis membuat folder jika belum ada
        $destinationPath = public_path('assets/img/profiles');
        $file->move($destinationPath, $fileName);

        // Simpan path relatifnya ke database agar mudah dipanggil
        $user->profile_photo_path = 'assets/img/profiles/' . $fileName;
    }

    // 3. Simpan data lainnya
    $user->name = $request->name;
    $user->save();

    return back()->with('success', 'Foto profil berhasil diperbarui di folder assets!');
}

}