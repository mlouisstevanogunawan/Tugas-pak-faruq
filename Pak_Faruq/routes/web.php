<?php

// Mengimpor controller ProfileController untuk menangani fitur manajemen profil pengguna
use App\Http\Controllers\PostController;
// Mengimpor controller PostController untuk menangani rute CRUD postingan
use App\Http\Controllers\ProfileController;
// Mengimpor facade Route dari framework Laravel untuk mendefinisikan rute HTTP
use Illuminate\Support\Facades\Route;
// Mengimpor kelas Inertia untuk merender komponen Vue dari server Laravel
use Inertia\Inertia;

/**
 * =========================================================================
 * Definisi Rute Web Aplikasi (Web Routes)
 * =========================================================================
 * Di file inilah seluruh endpoint dan URL aplikasi dideklarasikan.
 * Permintaan HTTP akan dicocokkan dengan rute di bawah ini dan diteruskan
 * ke controller atau fungsi closure yang sesuai.
 */

// Rute Halaman Utama (Landing Page / Welcome)
Route::get('/', function () {
    // Merender halaman Vue 'Welcome' yang terletak di resources/js/Pages/Welcome.vue
    return Inertia::render('Welcome', [
        // Menyediakan status apakah rute login tersedia dalam aplikasi
        'canLogin' => Route::has('login'),
        // Menyediakan status apakah rute registrasi akun tersedia dalam aplikasi
        'canRegister' => Route::has('register'),
        // Mengirimkan versi Laravel yang sedang digunakan oleh sistem
        'laravelVersion' => app()->version(),
        // Mengirimkan versi PHP yang sedang aktif menjalankan server
        'phpVersion' => PHP_VERSION,
    ]);
});

// Resource Route untuk Manajemen Posts
// Menyediakan seluruh endpoint CRUD otomatis (index, create, store, show, edit, update, destroy)
Route::resource('/posts', PostController::class);

// Rute Dashboard Pengguna
// Hanya dapat diakses oleh pengguna yang sudah berhasil login ('auth') dan emailnya terverifikasi ('verified')
Route::get('/dashboard', function () {
    // Merender halaman Vue 'Dashboard' yang terletak di resources/js/Pages/Dashboard.vue
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Kelompok Rute yang Terlindungi Autentikasi Pengguna
Route::middleware('auth')->group(function () {
    // Menampilkan halaman form untuk mengedit profil akun pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Menyimpan pembaruan data informasi profil akun pengguna
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Menghapus akun pengguna secara permanen dari sistem
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Memuat file rute autentikasi bawaan (login, register, reset password, logout) dari routes/auth.php
require __DIR__.'/auth.php';
