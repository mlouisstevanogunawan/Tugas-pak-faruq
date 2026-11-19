<script setup>
// Mengimpor komponen Layout utama dari direktori Layouts/App.vue
import Layout from '@/Layouts/App.vue';
// Mengimpor komponen Head untuk mengubah tag <title> dan Link untuk navigasi SPA
import { Head, Link, usePage } from '@inertiajs/vue3';
// Mengimpor computed dari Vue untuk mengambil informasi auth secara reaktif
import { computed } from 'vue';

// Mengakses objek global page dari Inertia.js
const page = usePage();

// Mengambil data pengguna yang sedang login saat ini
const user = computed(() => page.props.auth?.user);
</script>

<template>
    <!-- Membungkus halaman dengan Layout utama aplikasi -->
    <Layout>
        <!-- Mengatur judul halaman pada tab browser -->
        <Head title="Dashboard - Tugas Pak Faruq" />

        <!-- Container Grid Utama Dashboard -->
        <div class="row justify-content-center g-4 animate-fade-in">
            <!-- Kolom Banner Sambutan Utama -->
            <div class="col-12 col-lg-10">
                <!-- Kartu Banner Gradien Utama dengan Sudut Membulat Modern -->
                <div class="card border-0 rounded-4 shadow-sm text-white p-4 p-md-5 position-relative overflow-hidden" style="background: var(--primary-gradient) !important;">
                    <!-- Lingkaran Hiasan Latar Belakang Gradien 1 -->
                    <div class="position-absolute top-0 end-0 translate-middle-y rounded-circle bg-white opacity-10" style="width: 280px; height: 280px; filter: blur(20px);"></div>
                    <!-- Lingkaran Hiasan Latar Belakang Gradien 2 -->
                    <div class="position-absolute bottom-0 start-0 translate-middle rounded-circle bg-white opacity-10" style="width: 220px; height: 220px; filter: blur(30px);"></div>

                    <!-- Wadah Konten Banner -->
                    <div class="position-relative z-1">
                        <!-- Badge Status Login -->
                        <span class="badge bg-white bg-opacity-25 text-white mb-3 px-3 py-2 rounded-pill fw-semibold">
                            <i class="bi bi-person-check-fill me-1"></i> Akun Terverifikasi
                        </span>

                        <!-- Judul Selamat Datang dengan Nama Pengguna -->
                        <h2 class="display-6 fw-bold mb-2">
                            Selamat Datang, {{ user ? user.name : 'Pengguna' }}! 👋
                        </h2>

                        <!-- Deskripsi Pengantar Dashboard -->
                        <p class="mb-4 opacity-90 fs-6 fs-md-5 max-w-2xl">
                            Anda berhasil masuk ke dashboard sistem aplikasi Tugas Pak Faruq. 
                            Di sini Anda dapat mengelola data artikel, membuat postingan baru, dan memantau konten secara cepat dan responsif.
                        </p>

                        <!-- Baris Tombol Aksi Cepat pada Banner -->
                        <div class="d-flex flex-wrap gap-3">
                            <!-- Tombol Kelola Posts -->
                            <Link
                                href="/posts"
                                class="btn btn-light text-primary fw-bold rounded-pill px-4 py-2-5 shadow-sm d-inline-flex align-items-center gap-2 hover-lift"
                            >
                                <!-- Ikon Dokumen -->
                                <i class="bi bi-file-earmark-text-fill"></i>
                                <!-- Label Tombol -->
                                <span>Buka Data Posts</span>
                            </Link>

                            <!-- Tombol Buat Post Baru -->
                            <Link
                                href="/posts/create"
                                class="btn btn-outline-light fw-bold rounded-pill px-4 py-2-5 d-inline-flex align-items-center gap-2 hover-lift"
                            >
                                <!-- Ikon Tambah Data -->
                                <i class="bi bi-plus-circle-fill"></i>
                                <!-- Label Tombol -->
                                <span>Tambah Post Baru</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris Kartu Informasi / Statistik Singkat -->
            <div class="col-12 col-lg-10">
                <div class="row g-3">
                    <!-- Kartu Info 1: Manajemen Konten -->
                    <div class="col-12 col-md-4">
                        <div class="card border-0 rounded-4 shadow-sm p-4 bg-white hover-lift h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-collection-fill fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Manajemen Post</h6>
                                    <p class="text-muted small mb-0">Fitur CRUD lengkap dengan validasi form</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Info 2: Arsitektur Inertia -->
                    <div class="col-12 col-md-4">
                        <div class="card border-0 rounded-4 shadow-sm p-4 bg-white hover-lift h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-lightning-charge-fill fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Single Page App</h6>
                                    <p class="text-muted small mb-0">Transisi halaman cepat tanpa reload browser</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Info 3: Desain Responsif -->
                    <div class="col-12 col-md-4">
                        <div class="card border-0 rounded-4 shadow-sm p-4 bg-white hover-lift h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-phone-fill fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">100% Responsif</h6>
                                    <p class="text-muted small mb-0">Tampilan optimal di smartphone & desktop</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
/* Styling khusus dashboard */
.max-w-2xl {
    max-width: 42rem;
}
</style>
