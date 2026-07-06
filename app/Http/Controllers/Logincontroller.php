<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman form login.
     */
    public function showLoginForm()
    {
        // Kalau sudah login, jangan tampilkan form login lagi
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        // Tabel pengguna login pakai kolom "username", bukan "email"
        // Kalau kamu ingin login bisa pakai email ATAU username, lihat catatan di bawah file ini.
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            return $this->redirectByRole($role);
        }

        // Login gagal
        return back()
            ->withErrors(['username' => 'Username/email atau password salah.'])
            ->onlyInput('username');
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redirect sesuai role pengguna setelah login berhasil.
     */
    protected function redirectByRole($role)
    {
        return match ($role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'anggota' => redirect()->route('anggota.beranda'),
            default   => redirect()->route('login'),
        };
    }
}

/*
|--------------------------------------------------------------------------
| CATATAN PENTING
|--------------------------------------------------------------------------
|
| 1. Pastikan model Pengguna kamu (biasanya app/Models/User.php atau
|    app/Models/Pengguna.php) sudah extend Authenticatable, contoh:
|
|    use Illuminate\Foundation\Auth\User as Authenticatable;
|    class Pengguna extends Authenticatable { ... }
|
| 2. Kalau nama tabel/model kamu BUKAN "users" bawaan Laravel, tambahkan
|    di config/auth.php:
|
|    'providers' => [
|        'users' => [
|            'driver' => 'eloquent',
|            'model' => App\Models\Pengguna::class,
|        ],
|    ],
|
| 3. Kolom "password" di database HARUS berupa hash (bcrypt), bukan
|    plain text. Kalau data admin kamu masih plain text "password",
|    login akan selalu gagal. Cek dengan tinker:
|
|    php artisan tinker
|    >>> \App\Models\Pengguna::where('username','admin')->first()->password
|
|    Kalau hasilnya "password" polos (bukan string acak panjang seperti
|    $2y$12$...), berarti perlu di-hash ulang, contoh:
|
|    >>> $u = \App\Models\Pengguna::where('username','admin')->first();
|    >>> $u->password = bcrypt('password');
|    >>> $u->save();
|
| 4. Ingin login pakai username ATAU email dalam satu kolom input?
|    Ganti bagian Auth::attempt di atas dengan:
|
|    $field = filter_var($credentials['username'], FILTER_VALIDATE_EMAIL)
|        ? 'email' : 'username';
|
|    if (Auth::attempt([$field => $credentials['username'], 'password' => $credentials['password']], $remember)) {
|        ...
|    }
|
*/