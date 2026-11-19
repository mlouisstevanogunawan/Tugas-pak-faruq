<?php

// Mendefinisikan namespace untuk seeder database sesuai struktur folder Laravel

namespace Database\Seeders;

// Mengimpor model User dari namespace App\Models
use App\Models\Post;
// Mengimpor model Post dari namespace App\Models
use App\Models\User;
// Mengimpor trait WithoutModelEvents dari Illuminate\Database\Console\Seeds
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// Mengimpor kelas dasar Seeder dari Illuminate\Database\Seeder
use Illuminate\Database\Seeder;
// Mengimpor facade Hash untuk mengenkripsi kata sandi
use Illuminate\Support\Facades\Hash;

// Mendeklarasikan class DatabaseSeeder yang mewarisi class dasar Seeder
class DatabaseSeeder extends Seeder
{
    // Menggunakan trait WithoutModelEvents agar event model tidak dipicu selama proses seeding
    use WithoutModelEvents;

    /**
     * Menjalankan proses seeding data awal ke dalam database aplikasi.
     * Method run() ini akan dieksekusi saat perintah `php artisan db:seed` dijalankan.
     */
    public function run(): void
    {
        // Membuat akun pengguna default untuk pengujian jika belum ada di database
        User::firstOrCreate(
            // Parameter pertama: kondisi pencarian berdasarkan alamat email
            ['email' => 'test@example.com'],
            // Parameter kedua: data yang diisi jika pengguna baru dibuat
            [
                // Nama lengkap pengguna pengujian
                'name' => 'Pak Faruq User',
                // Password dienkripsi dengan algoritma bcrypt yang aman
                'password' => Hash::make('password'),
                // Menandai bahwa email pengguna sudah terverifikasi saat ini
                'email_verified_at' => now(),
            ]
        );

        // Memeriksa apakah tabel posts masih kosong sebelum menambahkan data contoh
        if (Post::count() === 0) {
            // Menambahkan data postingan pertama sebagai contoh panduan awal
            Post::create([
                // Judul postingan pertama
                'title' => 'Selamat Datang di Praktikum Inertia.js!',
                // Isi konten penjelasan mengenai Inertia.js dan Vue 3
                'content' => 'Inertia.js memungkinkan kita membangun Single Page Application (SPA) modern berbasis Vue 3 dengan kemudahan dan kenyamanan backend routing Laravel tanpa perlu membuat REST API terpisah.',
            ]);

            // Menambahkan data postingan kedua mengenai desain responsif
            Post::create([
                // Judul postingan kedua
                'title' => 'Tips Desain Web Responsif & Animasi Interaktif',
                // Isi konten postingan kedua
                'content' => 'Desain responsif memastikan aplikasi nyaman diakses baik melalui smartphone, tablet, maupun layar desktop. Animasi halus memberikan pengalaman pengguna yang elegan dan profesional.',
            ]);

            // Menambahkan data postingan ketiga mengenai fitur CRUD
            Post::create([
                // Judul postingan ketiga
                'title' => 'Panduan Pengelolaan Konten (CRUD Post)',
                // Isi konten postingan ketiga
                'content' => 'Gunakan tombol Tambah Data di halaman utama posts untuk membuat artikel baru, tombol Edit untuk memperbarui data, dan tombol Hapus untuk menghapus konten yang sudah tidak diperlukan.',
            ]);
        }
    }
}
