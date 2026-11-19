<script setup>
// Mengimpor komponen GuestLayout sebagai tata letak halaman autentikasi
import GuestLayout from '@/Layouts/GuestLayout.vue';
// Mengimpor komponen InputError untuk menampilkan pesan kesalahan validasi input
import InputError from '@/Components/InputError.vue';
// Mengimpor Head untuk judul tab, Link untuk navigasi SPA, dan useForm helper dari Inertia
import { Head, Link, useForm } from '@inertiajs/vue3';
// Mengimpor ref dari Vue 3 untuk mengontrol status toggle tampilan kata sandi
import { ref } from 'vue';

// Menginisialisasi state form pendaftaran menggunakan helper Inertia useForm
const form = useForm({
    // Isian nama pengguna awal
    name: '',
    // Isian email awal
    email: '',
    // Isian password awal
    password: '',
    // Isian konfirmasi password awal
    password_confirmation: '',
});

// State reaktif untuk toggle visibilitas kata sandi
const showPassword = ref(false);

// Fungsi untuk menangani pengiriman formulir registrasi akun baru
const submit = () => {
    // Mengirim permintaan HTTP POST ke endpoint rute register
    form.post(route('register'), {
        // Callback saat request selesai: reset kolom password dan konfirmasi
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <!-- Membungkus seluruh tampilan dengan GuestLayout -->
    <GuestLayout>
        <!-- Mengatur judul halaman pada tab browser -->
        <Head title="Daftar Akun Baru - Tugas Pak Faruq" />

        <!-- Header Kartu Registrasi -->
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark mb-1">Buat Akun Baru 🚀</h3>
            <p class="text-muted small">Lengkapi data Anda untuk mulai menggunakan aplikasi</p>
        </div>

        <!-- Formulir Pendaftaran Akun -->
        <form @submit.prevent="submit">
            <!-- Input Nama Lengkap -->
            <div class="mb-3">
                <label for="name" class="form-label fw-bold text-secondary small">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">
                        <i class="bi bi-person"></i>
                    </span>
                    <input
                        id="name"
                        type="text"
                        class="form-control bg-light border-start-0 rounded-end-3 py-2 ps-0"
                        :class="{ 'is-invalid': form.errors.name }"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Nama lengkap Anda"
                    />
                </div>
                <InputError class="mt-1" :message="form.errors.name" />
            </div>

            <!-- Input Alamat Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-bold text-secondary small">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input
                        id="email"
                        type="email"
                        class="form-control bg-light border-start-0 rounded-end-3 py-2 ps-0"
                        :class="{ 'is-invalid': form.errors.email }"
                        v-model="form.email"
                        required
                        autocomplete="username"
                        placeholder="nama@email.com"
                    />
                </div>
                <InputError class="mt-1" :message="form.errors.email" />
            </div>

            <!-- Input Kata Sandi -->
            <div class="mb-3">
                <label for="password" class="form-label fw-bold text-secondary small">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        class="form-control bg-light border-start-0 border-end-0 py-2 ps-0"
                        :class="{ 'is-invalid': form.errors.password }"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                    />
                    <button
                        type="button"
                        class="input-group-text bg-light border-start-0 rounded-end-3 text-muted"
                        @click="showPassword = !showPassword"
                        tabindex="-1"
                    >
                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                    </button>
                </div>
                <InputError class="mt-1" :message="form.errors.password" />
            </div>

            <!-- Input Konfirmasi Kata Sandi -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-bold text-secondary small">Konfirmasi Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted">
                        <i class="bi bi-shield-check"></i>
                    </span>
                    <input
                        id="password_confirmation"
                        :type="showPassword ? 'text' : 'password'"
                        class="form-control bg-light border-start-0 rounded-end-3 py-2 ps-0"
                        :class="{ 'is-invalid': form.errors.password_confirmation }"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Ulangi kata sandi"
                    />
                </div>
                <InputError class="mt-1" :message="form.errors.password_confirmation" />
            </div>

            <!-- Tombol Submit Pendaftaran Akun -->
            <button
                type="submit"
                class="btn btn-gradient-primary w-100 py-2-5 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 hover-lift"
                :disabled="form.processing"
            >
                <span v-if="form.processing" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <i v-else class="bi bi-person-plus-fill"></i>
                <span>{{ form.processing ? 'MEMPROSES...' : 'Daftar Akun Baru' }}</span>
            </button>

            <!-- Tautan Kembali ke Form Login -->
            <div class="text-center mt-4 pt-2 border-top">
                <p class="small text-muted mb-0">
                    Sudah memiliki akun? 
                    <Link :href="route('login')" class="text-primary fw-bold text-decoration-none ms-1">
                        Masuk di Sini
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>
