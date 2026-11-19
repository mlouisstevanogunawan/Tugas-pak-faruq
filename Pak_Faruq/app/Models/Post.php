<?php

// Mendefinisikan namespace tempat model Post berada di dalam folder app/Models

namespace App\Models;

// Mengimpor trait HasFactory untuk mendukung pembuatan data dummy melalui factory Eloquent
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Mengimpor kelas dasar Model dari framework Laravel Eloquent ORM
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * Model Eloquent yang merepresentasikan tabel 'posts' pada database.
 * Digunakan untuk melakukan operasi CRUD (Create, Read, Update, Delete) data postingan.
 */
class Post extends Model
{
    // Mengaktifkan trait HasFactory agar model dapat menggunakan PostFactory jika diperlukan
    use HasFactory;

    /**
     * Nama tabel yang diasosiasikan dengan model ini secara default adalah 'posts'.
     * Laravel secara otomatis mengasumsikan bentuk jamak (plural) dari nama model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * Atribut atau kolom tabel yang diizinkan untuk diisi secara massal (Mass Assignment).
     * Kolom selain yang didefinisikan di sini akan dilindungi oleh Eloquent dari pengisian tidak sah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Kolom untuk menyimpan judul dari postingan
        'title',
        // Kolom untuk menyimpan teks atau konten utama dari postingan
        'content',
    ];

    /**
     * Penyesuaian tipe data otomatis (casting) untuk kolom tertentu saat diambil dari database.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Memastikan kolom created_at diubah menjadi instance Carbon (Datetime)
        'created_at' => 'datetime',
        // Memastikan kolom updated_at diubah menjadi instance Carbon (Datetime)
        'updated_at' => 'datetime',
    ];
}
