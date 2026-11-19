<?php

// Mengimpor model Post dari namespace App\Models
use App\Models\Post;

// Menguji apakah halaman daftar postingan dapat diakses dan merender komponen Post/Index
it('dapat menampilkan halaman daftar post', function () {
    // Melakukan HTTP GET request ke endpoint /posts
    $response = $this->get('/posts');

    // Memastikan status respons adalah 200 OK
    $response->assertStatus(200);

    // Memastikan Inertia merender komponen 'Post/Index'
    $response->assertInertia(fn ($page) => $page->component('Post/Index'));
});

// Menguji apakah halaman formulir tambah post dapat diakses
it('dapat menampilkan halaman tambah post', function () {
    // Melakukan HTTP GET request ke /posts/create
    $response = $this->get('/posts/create');

    // Memastikan status respons adalah 200 OK
    $response->assertStatus(200);

    // Memastikan komponen yang dirender adalah 'Post/Create'
    $response->assertInertia(fn ($page) => $page->component('Post/Create'));
});

// Menguji apakah postingan baru berhasil disimpan ke database
it('dapat menyimpan postingan baru ke database', function () {
    // Data postingan baru yang akan dikirim
    $data = [
        'title' => 'Judul Postingan Pengujian',
        'content' => 'Ini adalah konten pengujian untuk memverifikasi fitur store post.',
    ];

    // Melakukan HTTP POST request ke /posts
    $response = $this->post('/posts', $data);

    // Memastikan dialihkan kembali ke rute posts.index
    $response->assertRedirect('/posts');

    // Memastikan data tersimpan di tabel database 'posts'
    $this->assertDatabaseHas('posts', [
        'title' => 'Judul Postingan Pengujian',
    ]);
});

// Menguji apakah halaman edit post dapat diakses dengan data yang benar
it('dapat menampilkan halaman edit post', function () {
    // Membuat sebuah data post di database
    $post = Post::create([
        'title' => 'Post Untuk Diedit',
        'content' => 'Konten awal sebelum diedit.',
    ]);

    // Mengakses rute /posts/{id}/edit
    $response = $this->get("/posts/{$post->id}/edit");

    // Memastikan status 200 OK
    $response->assertStatus(200);

    // Memastikan komponen Inertia adalah 'Post/Edit'
    $response->assertInertia(fn ($page) => $page->component('Post/Edit'));
});

// Menguji apakah data post berhasil diperbarui
it('dapat memperbarui postingan yang ada di database', function () {
    // Membuat post awal
    $post = Post::create([
        'title' => 'Judul Lama',
        'content' => 'Konten Lama',
    ]);

    // Data perubahan baru
    $updatedData = [
        'title' => 'Judul Telah Diperbarui',
        'content' => 'Konten Telah Diperbarui',
    ];

    // Mengirim HTTP PUT request ke /posts/{id}
    $response = $this->put("/posts/{$post->id}", $updatedData);

    // Memastikan redirect ke rute posts
    $response->assertRedirect('/posts');

    // Memastikan tabel posts sudah terupdate
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Judul Telah Diperbarui',
    ]);
});

// Menguji apakah data post berhasil dihapus
it('dapat menghapus postingan dari database', function () {
    // Membuat post yang akan dihapus
    $post = Post::create([
        'title' => 'Post Akan Dihapus',
        'content' => 'Konten ini akan segera dihapus.',
    ]);

    // Mengirim HTTP DELETE request ke /posts/{id}
    $response = $this->delete("/posts/{$post->id}");

    // Memastikan redirect ke rute posts
    $response->assertRedirect('/posts');

    // Memastikan data sudah tidak ada di database
    $this->assertDatabaseMissing('posts', [
        'id' => $post->id,
    ]);
});
