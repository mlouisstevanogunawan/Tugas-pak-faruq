<script setup>
// Mengimpor komponen Link dan fungsi usePage dari pustaka resmi Inertia Vue 3
import { Link, usePage } from '@inertiajs/vue3';
// Mengimpor ref dan computed dari Vue 3 untuk manajemen state reaktif
import { ref, computed } from 'vue';

// Mengambil objek halaman global dari Inertia.js untuk mengakses props bersama (shared props)
const page = usePage();

// Membuat computed property untuk mengekstrak data autentikasi pengguna secara reaktif
const auth = computed(() => page.props.auth);

// State reaktif untuk mengontrol buka-tutup menu navigasi pada layar mobile/smartphone
const isMobileMenuOpen = ref(false);

// Fungsi untuk mengubah status buka-tutup menu mobile (toggle)
const toggleMobileMenu = () => {
  // Membalikkan nilai boolean isMobileMenuOpen
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

// Fungsi untuk menutup menu mobile saat salah satu link navigasi diklik
const closeMobileMenu = () => {
  // Mengatur status menu mobile menjadi tertutup (false)
  isMobileMenuOpen.value = false;
};

// State reaktif untuk mengontrol visibilitas alert flash message
const showFlashMessage = ref(true);

// Fungsi untuk menutup flash message ketika tombol silang diklik
const dismissFlash = () => {
  // Mengatur nilai boolean menjadi false agar pesan tertutup
  showFlashMessage.value = false;
};
</script>

<template>
  <!-- Root Container Layout Tunggal (Single Root Element sesuai standar Vue 3 & Inertia) -->
  <div class="app-layout min-vh-100 d-flex flex-column bg-light">
    <!-- Navbar Header Utama dengan latar belakang gelap elegan dan blur kaca -->
    <header class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top shadow-sm">
      <!-- Container responsif Bootstrap -->
      <div class="container">
        <!-- Logo dan Nama Brand Aplikasi -->
        <Link class="navbar-brand d-flex align-items-center gap-2 fw-bold hover-scale" href="/" @click="closeMobileMenu">
          <!-- Ikon Roket Brand dengan latar gradien -->
          <div class="brand-icon-sm">
            <!-- Ikon Bootstrap Rocket -->
            <i class="bi bi-rocket-takeoff-fill"></i>
          </div>
          <!-- Teks Nama Brand Aplikasi -->
          <span class="tracking-tight text-white">TUGAS PAK FARUQ</span>
        </Link>

        <!-- Tombol Hamburger Responsif untuk Layar Mobile -->
        <button
          class="navbar-toggler border-0 p-2 shadow-none"
          type="button"
          aria-label="Toggle navigation"
          :aria-expanded="isMobileMenuOpen"
          @click="toggleMobileMenu"
        >
          <!-- Ikon hamburger dinamis: berganti ikon silang saat menu terbuka -->
          <i :class="isMobileMenuOpen ? 'bi bi-x-lg text-white fs-4' : 'bi bi-list text-white fs-4'"></i>
        </button>

        <!-- Menu Navigasi yang dapat dibuka-tutup di Mobile dan sejajar di Desktop -->
        <div class="collapse navbar-collapse" :class="{ 'show': isMobileMenuOpen }">
          <!-- Daftar Menu Navigasi Kiri -->
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3 gap-1">
            <!-- Menu Beranda -->
            <li class="nav-item">
              <Link
                class="nav-link px-3 rounded-3 d-flex align-items-center gap-2"
                href="/"
                :class="{ 'active fw-bold': $page.url === '/' }"
                @click="closeMobileMenu"
              >
                <!-- Ikon Home -->
                <i class="bi bi-house-door"></i>
                <!-- Label Menu -->
                <span>Beranda</span>
              </Link>
            </li>

            <!-- Menu Dashboard (jika user login) -->
            <li v-if="auth && auth.user" class="nav-item">
              <Link
                class="nav-link px-3 rounded-3 d-flex align-items-center gap-2"
                href="/dashboard"
                :class="{ 'active fw-bold': $page.url.startsWith('/dashboard') }"
                @click="closeMobileMenu"
              >
                <!-- Ikon Speedometer Dashboard -->
                <i class="bi bi-speedometer2"></i>
                <!-- Label Menu -->
                <span>Dashboard</span>
              </Link>
            </li>

            <!-- Menu Kelola Posts -->
            <li class="nav-item">
              <Link
                class="nav-link px-3 rounded-3 d-flex align-items-center gap-2"
                href="/posts"
                :class="{ 'active fw-bold': $page.url.startsWith('/posts') }"
                @click="closeMobileMenu"
              >
                <!-- Ikon File Text -->
                <i class="bi bi-file-earmark-text"></i>
                <!-- Label Menu -->
                <span>Data Posts</span>
              </Link>
            </li>
          </ul>

          <!-- Bagian Kanan Navbar: Info User / Tombol Login & Register -->
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-2">
            <!-- Blok Kondisional: Jika Pengguna Sudah Login -->
            <template v-if="auth && auth.user">
              <!-- Avatar dan Nama Pengguna Aktif -->
              <li class="nav-item text-white fw-semibold d-flex align-items-center gap-2 px-2 py-1">
                <!-- Lingkaran Avatar Inisial Nama -->
                <span class="brand-icon-sm bg-primary text-white rounded-circle fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                  {{ auth.user.name ? auth.user.name.charAt(0).toUpperCase() : 'U' }}
                </span>
                <!-- Menampilkan Nama Pengguna -->
                <span class="small">{{ auth.user.name }}</span>
              </li>

              <!-- Tombol Logout -->
              <li class="nav-item">
                <Link
                  href="/logout"
                  method="post"
                  as="button"
                  class="btn btn-outline-danger btn-sm rounded-pill px-3 py-1-5 d-inline-flex align-items-center gap-1 w-100 justify-content-center"
                  @click="closeMobileMenu"
                >
                  <!-- Ikon Logout -->
                  <i class="bi bi-box-arrow-right"></i>
                  <!-- Teks Tombol Logout -->
                  <span>Keluar</span>
                </Link>
              </li>
            </template>

            <!-- Blok Kondisional: Jika Pengguna Belum Login (Tamu / Guest) -->
            <template v-else>
              <!-- Tombol Masuk (Login) -->
              <li class="nav-item">
                <Link
                  href="/login"
                  class="btn btn-outline-light btn-sm rounded-pill px-3 py-1-5 d-inline-flex align-items-center gap-1 w-100 justify-content-center"
                  @click="closeMobileMenu"
                >
                  <!-- Ikon Login -->
                  <i class="bi bi-box-arrow-in-right"></i>
                  <!-- Teks Tombol Login -->
                  <span>Masuk</span>
                </Link>
              </li>

              <!-- Tombol Daftar Akun Baru (Register) -->
              <li class="nav-item">
                <Link
                  href="/register"
                  class="btn btn-gradient-primary btn-sm rounded-pill px-3 py-1-5 d-inline-flex align-items-center gap-1 w-100 justify-content-center shadow-sm"
                  @click="closeMobileMenu"
                >
                  <!-- Ikon Register -->
                  <i class="bi bi-person-plus"></i>
                  <!-- Teks Tombol Register -->
                  <span>Daftar</span>
                </Link>
              </li>
            </template>
          </ul>
        </div>
      </div>
    </header>

    <!-- Konten Utama Halaman (Main Content Area) -->
    <main class="container my-4 my-md-5 flex-grow-1 animate-fade-in">
      <!-- Flash Alert Notifikasi Sukses dengan Animasi Fade -->
      <Transition name="fade">
        <!-- Memeriksa apakah terdapat flash message dari session Laravel -->
        <div
          v-if="$page.props.flash?.message && showFlashMessage"
          class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center justify-content-between p-3 mb-4 animate-slide-down"
          role="alert"
        >
          <!-- Konten Ikon dan Teks Pesan -->
          <div class="d-flex align-items-center gap-3">
            <!-- Ikon Checklist Bulat -->
            <div class="bg-success text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="bi bi-check-lg fs-5"></i>
            </div>
            <!-- Teks Notifikasi dari Session Flash -->
            <div class="fw-medium text-dark">{{ $page.props.flash.message }}</div>
          </div>
          <!-- Tombol Tutup Notifikasi -->
          <button type="button" class="btn-close shadow-none" aria-label="Close" @click="dismissFlash"></button>
        </div>
      </Transition>

      <!-- Slot Tempat Halaman Anak (Child Pages) Dirender oleh Inertia -->
      <slot />
    </main>

    <!-- Footer Halaman Responsif -->
    <footer class="footer mt-auto py-4 bg-white border-top text-center text-muted small">
      <!-- Container Footer -->
      <div class="container">
        <!-- Baris Teks Hak Cipta dan Info Pembuatan -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
          <!-- Sisi Kiri: Nama Aplikasi dan Tahun Saat Ini -->
          <span>&copy; {{ new Date().getFullYear() }} <strong>Tugas Pak Faruq</strong> • Sistem CRUD Inertia.js</span>
          <!-- Sisi Kanan: Teknologi yang Digunakan -->
          <span class="text-secondary">
            Dibuat dengan <i class="bi bi-heart-fill text-danger mx-1"></i> Laravel 11 + Vue 3 + Bootstrap 5
          </span>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>
/* Styling Tambahan Khusus Komponen App Layout */
.app-layout {
  /* Memastikan font konsisten */
  font-family: inherit;
}

/* Transisi halus saat membuka menu mobile */
.collapse {
  transition: all 0.35s ease-in-out;
}
</style>
