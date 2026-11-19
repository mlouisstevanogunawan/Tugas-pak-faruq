<script setup>
// Mengimpor komponen Layout utama dari direktori Layouts/App.vue
import Layout from '../../Layouts/App.vue';
// Mengimpor reactive dan ref dari Vue 3 untuk manajemen formulir reaktif
import { reactive, ref } from 'vue';
// Mengimpor router dan Link serta Head dari pustaka resmi Inertia.js
import { router, Link, Head } from '@inertiajs/vue3';

// Mendefinisikan properti 'errors' yang dikirim secara otomatis oleh Laravel jika validasi gagal
defineProps({
    errors: {
        type: Object,
        default: () => ({}),
    },
});

// State reaktif untuk menyimpan data formulir postingan baru
const post = reactive({
    // Kolom judul postingan awal berstatus string kosong
    title: '',
    // Kolom isi postingan awal berstatus string kosong
    content: '',
});

// State reaktif untuk menandai apakah formulir sedang dalam proses pengiriman (loading)
const isSubmitting = ref(false);

// Fungsi untuk mengirimkan data formulir ke endpoint POST /posts
function storePost() {
    // Mengubah status isSubmitting menjadi true agar tombol menampilkan spinner loading
    isSubmitting.value = true;

    // Mengirimkan data objek post ke endpoint /posts menggunakan router Inertia
    router.post('/posts', post, {
        // Callback saat pengiriman berhasil atau selesai
        onFinish: () => {
            // Mengembalikan status submitting kembali ke false
            isSubmitting.value = false;
        },
    });
}

// Fungsi untuk mereset seluruh isian formulir kembali ke kondisi kosong
function resetForm() {
    // Mengosongkan nilai input judul
    post.title = '';
    // Mengosongkan nilai textarea konten
    post.content = '';
}
</script>

<template>
    <!-- Membungkus halaman tambah data dengan Layout utama aplikasi -->
    <Layout>
        <!-- Mengatur judul halaman pada tab browser -->
        <Head title="Tambah Post Baru - Tugas Pak Faruq" />

        <!-- Baris Grid Form yang Rapi dan Terpusat di Layar -->
        <div class="row justify-content-center animate-fade-in">
            <!-- Kolom responsif: full di mobile, 10 di tablet, 8 di desktop -->
            <div class="col-12 col-md-10 col-lg-8">
                <!-- Baris Navigasi Kembali dan Judul Halaman -->
                <div class="d-flex align-items-center mb-4 gap-3">
                    <!-- Tombol Kembali Berbentuk Lingkaran dengan Animasi Hover -->
                    <Link
                        href="/posts"
                        class="btn btn-white bg-white border shadow-sm rounded-circle p-0 d-flex align-items-center justify-content-center hover-scale"
                        style="width: 44px; height: 44px;"
                        title="Kembali ke Daftar Post"
                    >
                        <!-- Ikon Panah Kiri -->
                        <i class="bi bi-arrow-left fs-5 text-dark"></i>
                    </Link>

                    <!-- Judul dan Keterangan Formulir -->
                    <div>
                        <!-- Judul Form Tambah Post -->
                        <h3 class="fw-bold text-dark m-0">Tambah Post Baru</h3>
                        <!-- Deskripsi Singkat -->
                        <p class="text-muted small m-0">
                            Silakan isi judul dan konten artikel yang ingin Anda publikasikan.
                        </p>
                    </div>
                </div>

                <!-- Kartu Formulir dengan Sudut Melengkung dan Bayangan Lembut -->
                <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden animate-slide-up">
                    <div class="card-body p-4 p-md-5">
                        <!-- Formulir Tambah Post dengan Event Listener submit.prevent -->
                        <form @submit.prevent="storePost">
                            <!-- Input Judul Postingan -->
                            <div class="mb-4">
                                <!-- Label Input Judul -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold text-dark m-0">
                                        JUDUL POSTINGAN <span class="text-danger">*</span>
                                    </label>
                                    <!-- Penghitung Karakter Judul -->
                                    <span class="badge bg-light text-muted border small">
                                        {{ post.title.length }} / 255
                                    </span>
                                </div>

                                <!-- Kolom Input Teks Judul -->
                                <input
                                    type="text"
                                    class="form-control form-control-lg bg-light border-0 rounded-3 fs-6"
                                    :class="{ 'is-invalid': errors?.title }"
                                    v-model="post.title"
                                    placeholder="Contoh: Belajar Vue 3 dan Laravel 11"
                                    required
                                    maxlength="255"
                                />

                                <!-- Pesan Kesalahan Validasi Judul -->
                                <div v-if="errors?.title" class="invalid-feedback mt-1 fw-medium">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ errors.title }}
                                </div>
                            </div>

                            <!-- Input Area Konten Postingan -->
                            <div class="mb-4">
                                <!-- Label Input Konten -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold text-dark m-0">
                                        KONTEN ARTIKEL <span class="text-danger">*</span>
                                    </label>
                                    <!-- Penghitung Karakter Konten -->
                                    <span class="badge bg-light text-muted border small">
                                        {{ post.content.length }} karakter
                                    </span>
                                </div>

                                <!-- Textarea Input Konten -->
                                <textarea
                                    class="form-control form-control-lg bg-light border-0 rounded-3 fs-6"
                                    rows="6"
                                    :class="{ 'is-invalid': errors?.content }"
                                    v-model="post.content"
                                    placeholder="Tuliskan isi artikel atau postingan Anda secara lengkap di sini..."
                                    required
                                ></textarea>

                                <!-- Pesan Kesalahan Validasi Konten -->
                                <div v-if="errors?.content" class="invalid-feedback mt-1 fw-medium">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ errors.content }}
                                </div>
                            </div>

                            <!-- Baris Tombol Aksi Formulir (Simpan & Reset) Responsif -->
                            <div class="d-flex flex-column flex-sm-row gap-2 pt-2 border-top">
                                <!-- Tombol Submit Simpan Data -->
                                <button
                                    type="submit"
                                    class="btn btn-gradient-primary rounded-pill px-4 py-2-5 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 hover-lift"
                                    :disabled="isSubmitting"
                                >
                                    <!-- Ikon Spinner saat Sedang Memproses -->
                                    <span v-if="isSubmitting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <!-- Ikon Ceklis saat Normal -->
                                    <i v-else class="bi bi-check-circle-fill"></i>
                                    <!-- Label Tombol -->
                                    <span>{{ isSubmitting ? 'MENYIMPAN...' : 'SIMPAN POST' }}</span>
                                </button>

                                <!-- Tombol Reset Isian Form -->
                                <button
                                    type="button"
                                    @click="resetForm"
                                    class="btn btn-light border rounded-pill px-4 py-2-5 text-secondary fw-semibold hover-lift"
                                    :disabled="isSubmitting"
                                >
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> RESET FORM
                                </button>

                                <!-- Tombol Batal Kembali ke Posts -->
                                <Link
                                    href="/posts"
                                    class="btn btn-link text-secondary text-decoration-none px-3 py-2-5 ms-sm-auto text-center"
                                >
                                    Batal
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
