<script setup>
// Mengimpor komponen Head untuk mengubah tag <title> dan meta tag di browser
import { Head, Link } from '@inertiajs/vue3';

// Mendefinisikan properti yang dikirimkan oleh controller dari backend Laravel
defineProps({
    // Menunjukkan apakah fitur login tersedia dalam konfigurasi rute
    canLogin: {
        type: Boolean,
    },
    // Menunjukkan apakah fitur register tersedia dalam konfigurasi rute
    canRegister: {
        type: Boolean,
    },
    // Versi Laravel yang sedang berjalan di backend
    laravelVersion: {
        type: String,
        required: true,
    },
    // Versi PHP pada server backend
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <!-- Komponen Head untuk mengatur judul halaman pada tab browser -->
    <Head title="Selamat Datang - Tugas Pak Faruq" />

    <!-- Container Utama Seluruh Halaman Landing Page -->
    <div class="min-vh-100 d-flex flex-column bg-light font-sans antialiased overflow-hidden">
        <!-- Header Navigasi Landing Page -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3 sticky-top">
            <!-- Container responsif -->
            <div class="container">
                <!-- Brand Logo Navigasi -->
                <Link class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark hover-scale" href="/">
                    <!-- Wadah Ikon Logo dengan Gradien -->
                    <div class="brand-icon-sm">
                        <!-- Ikon Jurnal Kode -->
                        <i class="bi bi-journal-code"></i>
                    </div>
                    <!-- Teks Nama Aplikasi -->
                    <span class="fs-5 tracking-tight">Tugas Pak Faruq</span>
                </Link>

                <!-- Tombol Masuk atau Menuju Dashboard di Sisi Kanan Navbar -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Jika Pengguna Sudah Login, Tampilkan Tombol ke Dashboard -->
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="btn btn-outline-primary px-3 px-sm-4 rounded-pill fw-bold d-inline-flex align-items-center gap-2 shadow-sm"
                    >
                        <!-- Ikon Speedometer -->
                        <i class="bi bi-speedometer2"></i>
                        <!-- Label Tombol -->
                        <span>Dashboard</span>
                    </Link>

                    <!-- Jika Pengguna Belum Login, Tampilkan Tombol Masuk dan Daftar -->
                    <template v-else>
                        <!-- Tombol Masuk (Login) -->
                        <Link
                            :href="route('login')"
                            class="btn btn-gradient-primary px-3 px-sm-4 rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2"
                        >
                            <!-- Ikon Masuk -->
                            <i class="bi bi-box-arrow-in-right"></i>
                            <!-- Label Tombol -->
                            <span>Masuk</span>
                        </Link>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Area Konten Utama Halaman (Hero Section & Panduan) -->
        <main class="flex-grow-1 container py-4 py-lg-5 animate-fade-in">
            <!-- Bagian Baris Hero Section -->
            <div class="row align-items-center mb-5 pb-3 g-4">
                <!-- Kolom Teks Hero (Kiri) -->
                <div class="col-lg-6 pe-lg-4 text-center text-lg-start">
                    <!-- Badge Penanda Tugas dengan Animasi Halus -->
                    <div class="d-inline-flex align-items-center gap-2 badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill fw-bold border border-primary border-opacity-25 animate-float">
                        <!-- Ikon Bintang Kejora -->
                        <i class="bi bi-stars"></i>
                        <!-- Teks Badge -->
                        <span>#TugasPakFaruq • Inertia.js &amp; Vue 3</span>
                    </div>

                    <!-- Judul Utama Hero Section -->
                    <h1 class="display-5 fw-extrabold text-dark mb-3 lh-sm">
                        Aplikasi Pengelolaan <br class="d-none d-sm-inline">
                        <span class="text-primary text-decoration-underline text-underline-offset-4">Post &amp; Artikel</span> Modern
                    </h1>

                    <!-- Deskripsi Pengantar Hero Section -->
                    <p class="lead text-secondary mb-4 fs-6 fs-md-5">
                        Aplikasi ini merupakan implementasi Single Page Application (SPA) responsif yang menghubungkan 
                        kekuatan routing Laravel dengan fleksibilitas Vue 3 menggunakan Inertia.js. Lengkap dengan operasi CRUD, validasi, dan animasi interaktif.
                    </p>

                    <!-- Tombol Aksi Cepat (Call to Action) -->
                    <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3 mb-4">
                        <!-- Tombol Lihat Posts -->
                        <Link
                            href="/posts"
                            class="btn btn-gradient-primary btn-lg rounded-pill px-4 py-2-5 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2"
                        >
                            <!-- Ikon Daftar Artikel -->
                            <i class="bi bi-collection"></i>
                            <!-- Teks Tombol -->
                            <span>Kelola Data Posts</span>
                            <!-- Ikon Panah Kanan -->
                            <i class="bi bi-arrow-right"></i>
                        </Link>

                        <!-- Tombol Panduan Cara Pakai -->
                        <a
                            href="#tata-cara"
                            class="btn btn-white border border-2 rounded-pill px-4 py-2-5 fw-bold text-secondary d-flex align-items-center justify-content-center gap-2 hover-lift"
                        >
                            <!-- Ikon Info Lingkaran -->
                            <i class="bi bi-info-circle text-primary"></i>
                            <!-- Teks Tombol -->
                            <span>Panduan Penggunaan</span>
                        </a>
                    </div>

                    <!-- Mini Statistik Teknologi yang Digunakan -->
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-2 pt-2">
                        <!-- Badge Laravel -->
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                            <i class="bi bi-cpu me-1 text-danger"></i> Laravel {{ laravelVersion }}
                        </span>
                        <!-- Badge PHP -->
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                            <i class="bi bi-filetype-php me-1 text-primary"></i> PHP {{ phpVersion }}
                        </span>
                        <!-- Badge Vue 3 -->
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                            <i class="bi bi-lightning-charge me-1 text-success"></i> Vue 3 + Inertia
                        </span>
                        <!-- Badge Bootstrap 5 -->
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                            <i class="bi bi-bootstrap me-1 text-purple" style="color: #6366f1;"></i> Bootstrap 5
                        </span>
                    </div>
                </div>

                <!-- Kolom Ilustrasi Hero (Kanan) -->
                <div class="col-lg-6 text-center position-relative mt-4 mt-lg-0">
                    <!-- Lingkaran Efek Cahaya di Belakang Gambar -->
                    <div
                        class="position-absolute top-50 start-50 translate-middle rounded-circle"
                        style="width: 380px; height: 380px; background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%); filter: blur(30px); z-index: 0;"
                    ></div>

                    <!-- Gambar Ilustrasi Vektor dengan Animasi Mengambang (Floating) -->
                    <div class="position-relative z-1 animate-float">
                        <img
                            src="https://illustrations.popsy.co/amber/freelancer.svg"
                            alt="Ilustrasi Aplikasi Tugas"
                            class="img-fluid"
                            style="max-height: 420px; filter: drop-shadow(0 15px 25px rgba(99, 102, 241, 0.15));"
                        />
                    </div>
                </div>
            </div>

            <!-- Bagian Tata Cara Penggunaan (Steps Section) -->
            <section id="tata-cara" class="mt-5 pt-5 border-top">
                <!-- Judul dan Subjudul Bagian Panduan -->
                <div class="text-center mb-5">
                    <!-- Badge Seksi -->
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold mb-2">
                        PANDUAN LENGKAP
                    </span>
                    <!-- Judul Utama Seksi -->
                    <h2 class="fw-bolder text-dark mb-2">Tata Cara Penggunaan Aplikasi</h2>
                    <!-- Deskripsi Seksi -->
                    <p class="text-muted max-w-md mx-auto">
                        Ikuti tiga langkah sederhana berikut untuk mulai mengelola artikel dan konten pada aplikasi.
                    </p>
                </div>

                <!-- Baris Kartu 3 Langkah Mudah -->
                <div class="row g-4">
                    <!-- Kartu Langkah 1: Masuk Akun -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift p-3 bg-white">
                            <div class="card-body text-center p-3">
                                <!-- Ikon Langkah 1 -->
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 72px; height: 72px;">
                                    <i class="bi bi-box-arrow-in-right fs-2"></i>
                                </div>
                                <!-- Judul Langkah 1 -->
                                <h5 class="fw-bold mb-2">1. Masuk ke Akun</h5>
                                <!-- Penjelasan Langkah 1 -->
                                <p class="text-secondary small mb-0">
                                    Gunakan tombol Masuk untuk login dengan akun yang tersedia atau daftar akun baru untuk memulai.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Langkah 2: Kelola Data Post -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift p-3 bg-white">
                            <div class="card-body text-center p-3">
                                <!-- Ikon Langkah 2 -->
                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 72px; height: 72px;">
                                    <i class="bi bi-card-checklist fs-2"></i>
                                </div>
                                <!-- Judul Langkah 2 -->
                                <h5 class="fw-bold mb-2">2. Kelola Data Post</h5>
                                <!-- Penjelasan Langkah 2 -->
                                <p class="text-secondary small mb-0">
                                    Akses halaman Data Posts untuk membuat artikel baru, melihat daftar, menyunting, atau menghapus postingan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Langkah 3: Selesai & Real-Time -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift p-3 bg-white">
                            <div class="card-body text-center p-3">
                                <!-- Ikon Langkah 3 -->
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 72px; height: 72px;">
                                    <i class="bi bi-shield-check fs-2"></i>
                                </div>
                                <!-- Judul Langkah 3 -->
                                <h5 class="fw-bold mb-2">3. Selesai &amp; Aman</h5>
                                <!-- Penjelasan Langkah 3 -->
                                <p class="text-secondary small mb-0">
                                    Perubahan data tersimpan secara otomatis ke database dengan validasi yang ketat dan keamanan terjamin.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer Halaman Landing Page -->
        <footer class="bg-white py-4 mt-5 border-top">
            <!-- Container Footer -->
            <div class="container text-center">
                <!-- Teks Hak Cipta -->
                <p class="text-secondary small mb-0">
                    &copy; {{ new Date().getFullYear() }} <strong>Tugas Pak Faruq</strong> • Dibangun menggunakan 
                    <span class="fw-semibold text-dark">Laravel {{ laravelVersion }}</span>, 
                    <span class="fw-semibold text-dark">Vue 3</span>, dan 
                    <span class="fw-semibold text-dark">Inertia.js</span>.
                </p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* Styling khusus kelas hover-lift pada kartu */
.hover-lift {
    transition: transform 0.25s ease-in-out, box-shadow 0.25s ease-in-out;
}
.hover-lift:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 28px rgba(99, 102, 241, 0.12) !important;
}
</style>
