<?php

// Mendefinisikan namespace untuk controller ini agar dikenali di dalam struktur folder app/Http/Controllers

namespace App\Http\Controllers;

// Mengimpor model Post untuk berinteraksi dengan tabel posts di database melalui Eloquent ORM
use App\Models\Post;
// Mengimpor kelas utama Inertia untuk merender komponen Vue dari server-side
use Illuminate\Http\RedirectResponse;
// Mengimpor tipe respons Inertia Response untuk type-hinting return value
use Illuminate\Http\Request;
// Mengimpor Request dari Illuminate untuk menangani input HTTP dari form pengguna
use Illuminate\Support\Facades\Redirect;
// Mengimpor RedirectResponse untuk type-hinting pengalihan rute setelah operasi selesai
use Inertia\Inertia;
// Mengimpor facade Redirect untuk melakukan pengalihan halaman (redirect)
use Inertia\Response;

/**
 * Class PostController
 *
 * Controller yang bertanggung jawab menangani seluruh logika bisnis dan alur kerja CRUD
 * untuk data postingan (Posts) menggunakan integrasi Laravel dan Inertia.js (Vue 3).
 */
class PostController extends Controller
{
    /**
     * Menampilkan daftar seluruh postingan yang diurutkan dari yang paling baru.
     * Mengambil data dari database dan merender komponen Vue 'Post/Index'.
     *
     * @return Response Objek respons Inertia yang merender komponen halaman daftar post
     */
    public function index(): Response
    {
        // Mengambil semua data postingan dari tabel posts, diurutkan berdasarkan created_at descending (terbaru)
        $posts = Post::latest()->get();

        // Merender tampilan antarmuka Vue pada direktori resources/js/Pages/Post/Index.vue
        // dan mengirimkan variabel data $posts ke props komponen Vue
        return Inertia::render('Post/Index', [
            // Mempassing array kumpulan objek post ke frontend Vue
            'posts' => $posts,
        ]);
    }

    /**
     * Menampilkan formulir pembuatan postingan baru.
     * Merender komponen Vue 'Post/Create'.
     *
     * @return Response Objek respons Inertia yang merender halaman form tambah post
     */
    public function create(): Response
    {
        // Merender tampilan form penambahan postingan baru di resources/js/Pages/Post/Create.vue
        return Inertia::render('Post/Create');
    }

    /**
     * Menyimpan data postingan baru yang dikirimkan melalui formulir ke dalam database.
     *
     * @param  Request  $request  Objek permintaan HTTP yang berisi input data dari pengguna
     * @return RedirectResponse Pengalihan kembali ke halaman daftar post dengan pesan sukses
     */
    public function store(Request $request): RedirectResponse
    {
        // Menjalankan validasi terhadap data input agar judul dan isi postingan tidak boleh kosong
        $validatedData = $request->validate([
            // Input 'title' wajib diisi (required), berupa teks string, dan maksimal 255 karakter
            'title' => 'required|string|max:255',
            // Input 'content' wajib diisi (required) dan berupa teks string
            'content' => 'required|string',
        ]);

        // Menyimpan data postingan baru ke dalam tabel 'posts' menggunakan Eloquent Post::create
        Post::create([
            // Mengisi atribut title dengan nilai yang telah divalidasi
            'title' => $validatedData['title'],
            // Mengisi atribut content dengan nilai yang telah divalidasi
            'content' => $validatedData['content'],
        ]);

        // Mengalihkan kembali pengguna ke rute 'posts.index' dengan menyertakan flash session message
        return Redirect::route('posts.index')->with('message', 'Postingan baru berhasil disimpan!');
    }

    /**
     * Menampilkan formulir untuk mengubah data postingan yang sudah ada.
     * Laravel menggunakan Route Model Binding untuk menyuntikkan instance Post berdasarkan ID.
     *
     * @param  Post  $post  Model Post yang ditemukan secara otomatis oleh Laravel Route Model Binding
     * @return Response Objek respons Inertia yang merender form edit postingan
     */
    public function edit(Post $post): Response
    {
        // Merender tampilan antarmuka Vue pada direktori resources/js/Pages/Post/Edit.vue
        // dan mengirimkan data model $post yang dipilih ke props komponen
        return Inertia::render('Post/Edit', [
            // Mengirim objek post yang sedang diedit ke frontend
            'post' => $post,
        ]);
    }

    /**
     * Memperbarui data postingan tertentu di dalam database setelah diedit oleh pengguna.
     *
     * @param  Request  $request  Objek permintaan HTTP berisi data input perubahan
     * @param  Post  $post  Instance model Post yang akan diperbarui
     * @return RedirectResponse Pengalihan kembali ke halaman daftar post dengan notifikasi sukses
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        // Melakukan validasi terhadap perubahan data input pengguna
        $validatedData = $request->validate([
            // Judul postingan wajib diisi (required), tipe string, dan maksimal 255 karakter
            'title' => 'required|string|max:255',
            // Konten postingan wajib diisi (required) dan berupa teks string
            'content' => 'required|string',
        ]);

        // Memperbarui atribut record postingan di database dengan data baru yang sudah divalidasi
        $post->update([
            // Memperbarui nilai kolom title
            'title' => $validatedData['title'],
            // Memperbarui nilai kolom content
            'content' => $validatedData['content'],
        ]);

        // Mengalihkan pengguna kembali ke halaman daftar postingan dengan pesan flash sukses
        return Redirect::route('posts.index')->with('message', 'Data postingan berhasil diperbarui!');
    }

    /**
     * Menghapus rekaman data postingan tertentu dari database secara permanen.
     *
     * @param  Post  $post  Instance model Post yang akan dihapus berdasarkan ID rute
     * @return RedirectResponse Pengalihan kembali ke rute posts.index dengan notifikasi penghapusan
     */
    public function destroy(Post $post): RedirectResponse
    {
        // Menjalankan perintah delete pada record model Post dari database
        $post->delete();

        // Mengalihkan pengguna kembali ke rute 'posts.index' dengan membawa flash session message
        return Redirect::route('posts.index')->with('message', 'Postingan berhasil dihapus dari sistem!');
    }
}
