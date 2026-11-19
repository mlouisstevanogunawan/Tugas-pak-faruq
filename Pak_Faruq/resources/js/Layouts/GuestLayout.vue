<script setup>
// Mengimpor komponen Link dari library resmi Inertia Vue 3 untuk navigasi SPA cepat
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <!-- Root Container Layout Tamu (Guest Layout) dengan latar belakang gradien dinamis -->
  <div class="auth-wrapper min-vh-100 d-flex align-items-center justify-content-center p-3 position-relative overflow-hidden">
    <!-- Lingkaran Hiasan Gradien Pertama di Belakang Layar (Floating Blob 1) -->
    <div
      class="position-absolute rounded-circle animate-float"
      style="width: 320px; height: 320px; background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%); top: -50px; left: -50px; filter: blur(40px); z-index: 0; pointer-events: none;"
    ></div>

    <!-- Lingkaran Hiasan Gradien Kedua di Belakang Layar (Floating Blob 2) -->
    <div
      class="position-absolute rounded-circle animate-float"
      style="width: 380px; height: 380px; background: radial-gradient(circle, rgba(236, 72, 153, 0.2) 0%, transparent 70%); bottom: -60px; right: -60px; filter: blur(50px); z-index: 0; animation-delay: -1.8s; pointer-events: none;"
    ></div>

    <!-- Container Kartu Autentikasi dengan Lebar Maksimal Responsif -->
    <div class="auth-card-container position-relative z-1 w-100" style="max-width: 460px;">
      <!-- Bagian Header Logo dan Judul Aplikasi -->
      <div class="text-center mb-4 animate-fade-in">
        <!-- Tautan ke Halaman Utama -->
        <Link href="/" class="d-inline-flex align-items-center text-decoration-none gap-2 hover-scale">
          <!-- Ikon Kotak Brand dengan Latar Gradien Primer -->
          <div class="brand-icon-wrapper">
            <!-- Ikon Bootstrap Box Seam Fill -->
            <i class="bi bi-box-seam-fill brand-icon"></i>
          </div>
          <!-- Teks Judul Brand -->
          <span class="brand-title">TUGAS PAK FARUQ</span>
        </Link>
      </div>

      <!-- Kartu Autentikasi dengan Efek Glassmorphism dan Animasi Slide Up -->
      <div class="auth-card glass-card shadow-lg border-0 rounded-4 overflow-hidden animate-slide-up">
        <!-- Body Kartu dengan Padding Responsif -->
        <div class="auth-card-body p-4 p-sm-5">
          <!-- Slot Tempat Form (Login / Register / Forgot Password) Dirender -->
          <slot />
        </div>
      </div>

      <!-- Footer Hak Cipta di Bawah Kartu -->
      <div class="text-center mt-4 animate-fade-in">
        <!-- Informasi Hak Cipta dan Framework -->
        <p class="text-muted small mb-0">
          &copy; {{ new Date().getFullYear() }} Tugas Pak Faruq • Powered by Laravel &amp; Vue 3
        </p>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Transisi halus kartu autentikasi */
.auth-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
</style>
