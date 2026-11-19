<script setup>
// Mengimpor komponen Layout utama dari direktori Layouts/App.vue
import Layout from '../../Layouts/App.vue';
// Mengimpor Link untuk navigasi SPA dan router untuk mengirim request HTTP DELETE
import { Link, router, Head } from '@inertiajs/vue3';
// Mengimpor ref dan computed dari Vue 3 untuk membuat state pencarian reaktif
import { ref, computed } from 'vue';

// Mendefinisikan properti 'posts' yang diterima dari PostController::index
const props = defineProps({
    // posts bertipe Array yang berisi kumpulan objek postingan
    posts: {
        type: Array,
        default: () => [],
    },
});

// State reaktif untuk menyimpan kata kunci pencarian yang diketik pengguna
const searchQuery = ref('');

// Computed property untuk memfilter daftar postingan secara real-time di sisi client
const filteredPosts = computed(() => {
    // Jika kolom pencarian kosong, kembalikan seluruh postingan asli
    if (!searchQuery.value.trim()) {
        return props.posts;
    }
    // Mengubah kata kunci menjadi huruf kecil untuk pencarian case-insensitive
    const query = searchQuery.value.toLowerCase();
    // Memfilter postingan yang judul atau kontennya cocok dengan kata kunci
    return props.posts.filter((post) => {
        const titleMatch = post.title && post.title.toLowerCase().includes(query);
        const contentMatch = post.content && post.content.toLowerCase().includes(query);
        return titleMatch || contentMatch;
    });
});

// Fungsi untuk menghapus data post berdasarkan ID dengan konfirmasi pengguna
function deletePost(id) {
    // Menampilkan kotak dialog konfirmasi bawaan browser sebelum menghapus data
    if (confirm('Apakah Anda yakin ingin menghapus data post ini secara permanen?')) {
        // Mengirimkan permintaan HTTP DELETE ke rute /posts/{id} menggunakan router Inertia
        router.delete(`/posts/${id}`, {
            // Mempertahankan posisi scroll halaman setelah operasi selesai
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <!-- Membungkus seluruh tampilan dengan Layout utama aplikasi -->
    <Layout>
        <!-- Mengatur judul halaman pada tab browser -->
        <Head title="Data Posts - Tugas Pak Faruq" />

        <!-- Baris Utama Konten Halaman Posts -->
        <div class="row g-4 animate-fade-in">
            <div class="col-12">
                <!-- Header Atas: Judul Halaman dan Tombol Tambah Data -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                    <!-- Sisi Kiri: Judul dan Keterangan -->
                    <div>
                        <!-- Judul Halaman Data Posts -->
                        <h2 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                            <!-- Ikon Dokumen Koleksi -->
                            <i class="bi bi-file-earmark-text text-primary"></i>
                            <span>Data Posts</span>
                        </h2>
                        <!-- Deskripsi Singkat di Bawah Judul -->
                        <p class="text-muted small m-0 mt-1">
                            Kelola seluruh postingan artikel dan konten aplikasi Anda di sini.
                        </p>
                    </div>

                    <!-- Sisi Kanan: Tombol Tambah Data Baru -->
                    <div>
                        <!-- Tombol Tambah Post dengan Efek Gradien dan Animasi Angkat (Hover-Lift) -->
                        <Link
                            href="/posts/create"
                            class="btn btn-gradient-primary rounded-pill px-4 py-2-5 shadow-sm d-inline-flex align-items-center gap-2 hover-lift w-100 w-sm-auto justify-content-center"
                        >
                            <!-- Ikon Plus Lingkaran -->
                            <i class="bi bi-plus-circle-fill fs-6"></i>
                            <!-- Label Tombol Tambah Data -->
                            <span class="fw-bold">TAMBAH DATA</span>
                        </Link>
                    </div>
                </div>

                <!-- Baris Filter Pencarian dan Jumlah Total Post -->
                <div class="card border-0 rounded-4 shadow-sm mb-4 bg-white">
                    <div class="card-body p-3 p-md-4">
                        <div class="row align-items-center g-3">
                            <!-- Input Pencarian Real-Time -->
                            <div class="col-12 col-md-8">
                                <div class="input-group">
                                    <!-- Ikon Kaca Pembesar di Sisi Kiri Input -->
                                    <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-muted">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <!-- Input Teks untuk Memfilter Postingan -->
                                    <input
                                        type="text"
                                        class="form-control bg-light border-start-0 rounded-end-pill py-2"
                                        placeholder="Cari berdasarkan judul atau konten post..."
                                        v-model="searchQuery"
                                    />
                                </div>
                            </div>

                            <!-- Lencana / Badge Jumlah Postingan -->
                            <div class="col-12 col-md-4 text-md-end">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold">
                                    <i class="bi bi-layers-fill me-1"></i>
                                    Menampilkan {{ filteredPosts.length }} dari {{ posts.length }} Post
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tampilan 1: Tabel untuk Layar Desktop dan Tablet (d-none d-md-block) -->
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden bg-white d-none d-md-block">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <!-- Header Kolom Tabel -->
                                <thead class="table-light">
                                    <tr>
                                        <!-- Kolom Nomor -->
                                        <th scope="col" class="px-4 py-3 text-secondary fs-7 fw-bold" style="width: 60px;">NO</th>
                                        <!-- Kolom Judul Post -->
                                        <th scope="col" class="px-4 py-3 text-secondary fs-7 fw-bold" style="width: 30%;">JUDUL POST</th>
                                        <!-- Kolom Konten Post -->
                                        <th scope="col" class="px-4 py-3 text-secondary fs-7 fw-bold">KONTEN</th>
                                        <!-- Kolom Aksi (Edit & Hapus) -->
                                        <th scope="col" class="px-4 py-3 text-secondary fs-7 fw-bold text-end" style="width: 180px;">AKSI</th>
                                    </tr>
                                </thead>

                                <!-- Isi Baris Tabel dengan Animasi Transisi Vue -->
                                <TransitionGroup name="list" tag="tbody">
                                    <!-- Kondisi Jika Belum Ada Data atau Pencarian Tidak Ditemukan -->
                                    <tr v-if="!filteredPosts || filteredPosts.length === 0" key="empty-state">
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <!-- Ikon Kotak Kosong -->
                                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50 animate-float"></i>
                                            <!-- Keterangan Belum Ada Data -->
                                            <span class="fw-medium">
                                                {{ searchQuery ? 'Tidak ada postingan yang sesuai dengan pencarian.' : 'Belum ada data post. Silakan tambah data baru!' }}
                                            </span>
                                        </td>
                                    </tr>

                                    <!-- Looping Baris Data Postingan -->
                                    <tr v-for="(post, index) in filteredPosts" :key="post.id" class="table-row-item">
                                        <!-- Nomor Urut -->
                                        <td class="px-4 py-3 text-muted fw-medium">{{ index + 1 }}</td>

                                        <!-- Judul Postingan -->
                                        <td class="px-4 py-3">
                                            <div class="fw-bold text-dark">{{ post.title }}</div>
                                            <span class="badge bg-light text-secondary border small mt-1">ID: #{{ post.id }}</span>
                                        </td>

                                        <!-- Konten Postingan (Dibatasi Teks Truncate Agar Rapi) -->
                                        <td class="px-4 py-3 text-secondary text-truncate" style="max-width: 380px;">
                                            {{ post.content }}
                                        </td>

                                        <!-- Tombol Aksi Edit dan Hapus -->
                                        <td class="px-4 py-3 text-end">
                                            <div class="d-inline-flex gap-2">
                                                <!-- Tombol Edit Post -->
                                                <Link
                                                    :href="`/posts/${post.id}/edit`"
                                                    class="btn btn-sm btn-outline-primary rounded-pill px-3 d-inline-flex align-items-center gap-1 hover-lift"
                                                >
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>EDIT</span>
                                                </Link>

                                                <!-- Tombol Hapus Post -->
                                                <button
                                                    @click.prevent="deletePost(post.id)"
                                                    class="btn btn-sm btn-outline-danger rounded-pill px-3 d-inline-flex align-items-center gap-1 hover-lift"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                    <span>HAPUS</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </TransitionGroup>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tampilan 2: Kartu Responsif Khusus Layar Smartphone (d-block d-md-none) -->
                <div class="d-block d-md-none">
                    <!-- Kondisi Kosong pada Tampilan Ponsel -->
                    <div v-if="!filteredPosts || filteredPosts.length === 0" class="card border-0 rounded-4 shadow-sm p-5 text-center bg-white">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50 animate-float"></i>
                        <span class="text-muted fw-medium">
                            {{ searchQuery ? 'Tidak ada postingan yang sesuai dengan kata kunci.' : 'Belum ada data post. Silakan tambah data baru!' }}
                        </span>
                    </div>

                    <!-- Looping Kartu Postingan untuk Mobile -->
                    <TransitionGroup name="list" tag="div" class="d-flex flex-column gap-3">
                        <div
                            v-for="post in filteredPosts"
                            :key="post.id"
                            class="card border-0 rounded-4 shadow-sm p-3 bg-white post-mobile-card"
                        >
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 small">
                                    #{{ post.id }}
                                </span>
                                <small class="text-muted">Postingan</small>
                            </div>

                            <!-- Judul Postingan Mobile -->
                            <h5 class="fw-bold text-dark mb-2">{{ post.title }}</h5>

                            <!-- Isi Konten Postingan Mobile -->
                            <p class="text-secondary small mb-3 line-clamp-3">
                                {{ post.content }}
                            </p>

                            <!-- Tombol Aksi Mobile yang Lebar dan Mudah Ditekan -->
                            <div class="d-flex gap-2 pt-2 border-top">
                                <Link
                                    :href="`/posts/${post.id}/edit`"
                                    class="btn btn-sm btn-outline-primary rounded-pill flex-grow-1 py-2 d-inline-flex align-items-center justify-content-center gap-1"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                    <span>EDIT</span>
                                </Link>

                                <button
                                    @click.prevent="deletePost(post.id)"
                                    class="btn btn-sm btn-outline-danger rounded-pill flex-grow-1 py-2 d-inline-flex align-items-center justify-content-center gap-1"
                                >
                                    <i class="bi bi-trash"></i>
                                    <span>HAPUS</span>
                                </button>
                            </div>
                        </div>
                    </TransitionGroup>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
/* Membatasi teks konten di tampilan mobile maksimal 3 baris */
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
