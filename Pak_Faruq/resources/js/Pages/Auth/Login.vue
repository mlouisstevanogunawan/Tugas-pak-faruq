<script setup>
// Mengimpor layout khusus halaman tamu (GuestLayout)
import GuestLayout from '@/Layouts/GuestLayout.vue';
// Mengimpor komponen penampil pesan error validasi input
import InputError from '@/Components/InputError.vue';
// Mengimpor komponen Head, Link, dan form helper useForm dari Inertia Vue 3
import { Head, Link, useForm } from '@inertiajs/vue3';
// Mengimpor ref dari Vue 3 untuk toggle visibility password
import { ref } from 'vue';

// Menerima properti canResetPassword dan status notifikasi dari backend Laravel
defineProps({
    // Status apakah fitur reset password aktif
    canResetPassword: {
        type: Boolean,
    },
    // Pesan status (misalnya setelah berhasil reset password)
    status: {
        type: String,
    },
});

// Menginisialisasi form helper reaktif Inertia useForm
const form = useForm({
    // Isian email awal kosong
    email: '',
    // Isian password awal kosong
    password: '',
    // Nilai checkbox ingat saya (default: false)
    remember: false,
});

// State reaktif untuk toggle lihat / sembunyikan kata sandi
const showPassword = ref(false);

// Fungsi untuk submit form login
const submit = () => {
    // Mengirim data form via HTTP POST ke rute login Laravel
    form.post(route('login'), {
        // Callback saat request selesai: kosongkan input password demi keamanan
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <!-- Membungkus dengan GuestLayout yang memiliki latar gradien mengambang -->
    <GuestLayout>
        <!-- Mengatur judul halaman pada tab browser -->
        <Head title="Masuk - Tugas Pak Faruq" />

        <!-- Header Kartu Login -->
        <div class="text-center mb-4">
            <!-- Tautan Kembali ke Halaman Beranda -->
            <div class="mb-3">
                <Link href="/" class="text-decoration-none text-muted small hover-lift d-inline-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali ke Beranda</span>
                </Link>
            </div>
            <!-- Judul Sambutan -->
            <h3 class="fw-bold text-dark mb-1">Selamat Datang Kembali! 👋</h3>
            <!-- Keterangan Login -->
            <p class="text-muted small">Silakan masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <!-- Alert Status Pesan Sukses (Jika Ada) -->
        <div v-if="status" class="alert alert-success border-0 rounded-3 mb-4 shadow-sm text-center">
            {{ status }}
        </div>

        <!-- Formulir Login -->
        <form @submit.prevent="submit">
            <!-- Input Email -->
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
                        autofocus
                        autocomplete="username"
                        placeholder="nama@email.com"
                    />
                </div>
                <InputError class="mt-1" :message="form.errors.email" />
            </div>

            <!-- Input Password -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label fw-bold text-secondary small mb-0">Kata Sandi</label>
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-decoration-none small text-primary fw-semibold"
                    >
                        Lupa sandi?
                    </Link>
                </div>
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
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <!-- Tombol Toggle Lihat Password -->
                    <button
                        type="button"
                        class="input-group-text bg-light border-start-0 rounded-end-3 text-muted cursor-pointer"
                        @click="showPassword = !showPassword"
                        tabindex="-1"
                    >
                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                    </button>
                </div>
                <InputError class="mt-1" :message="form.errors.password" />
            </div>

            <!-- Checkbox Ingat Saya -->
            <div class="mb-4 form-check">
                <input 
                    type="checkbox" 
                    class="form-check-input" 
                    id="remember" 
                    v-model="form.remember"
                />
                <label class="form-check-label small text-secondary" for="remember">
                    Ingat saya di perangkat ini
                </label>
            </div>

            <!-- Tombol Submit Masuk -->
            <button
                type="submit"
                class="btn btn-gradient-primary w-100 py-2-5 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 hover-lift"
                :disabled="form.processing"
            >
                <span v-if="form.processing" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <i v-else class="bi bi-box-arrow-in-right"></i>
                <span>{{ form.processing ? 'MEMPROSES...' : 'Masuk Sekarang' }}</span>
            </button>

            <!-- Tautan ke Halaman Registrasi Akun Baru -->
            <div class="text-center mt-4 pt-2 border-top">
                <p class="small text-muted mb-0">
                    Belum punya akun? 
                    <Link :href="route('register')" class="text-primary fw-bold text-decoration-none ms-1">
                        Daftar Akun Baru
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>
