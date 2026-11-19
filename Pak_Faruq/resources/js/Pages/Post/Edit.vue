<script setup>
// Mengimpor komponen Layout utama dari direktori Layouts/App.vue
import Layout from '../../Layouts/App.vue';
// Mengimpor reactive dan ref dari pustaka inti Vue 3
import { reactive, ref } from 'vue';
// Mengimpor router, Link, dan Head dari Inertia.js untuk Vue 3
import { router, Link, Head } from '@inertiajs/vue3';

// Mendefinisikan properti 'post' dan 'errors' yang dikirimkan oleh PostController::edit
const props = defineProps({
    // Objek post yang sedang diedit berisi id, title, content
    post: {
        type: Object,
        required: true,
    },
    // Objek errors yang berisi pesan kesalahan validasi dari backend
    errors: {
        type: Object,
        default: () => ({}),
    },
});

// State formulir reaktif yang diinisialisasi dengan data post saat ini
const postForm = reactive({
    // Mengisi judul awal dari data database
    title: props.post ? props.post.title : '',
    // Mengisi konten awal dari data database
    content: props.post ? props.post.content : '',
});

// State reaktif untuk menandai apakah formulir sedang diproses
const isSubmitting = ref(false);

// Fungsi untuk memperbarui data postingan via HTTP PUT ke /posts/{id}
function updatePost() {
    // Menandai proses update dimulai
    isSubmitting.value = true;

    // Mengirim permintaan HTTP PUT ke endpoint spesifik post
    router.put(`/posts/${props.post.id}`, postForm, {
        // Callback saat request selesai (baik sukses maupun error)
        onFinish: () => {
            // Mengembalikan status tombol menjadi normal
            isSubmitting.value = false;
        },
    });
}

// Fungsi untuk mengembalikan isian form ke nilai awal dari database
function resetForm() {
    // Mengembalikan nilai input title ke data awal
    postForm.title = props.post.title;
    // Mengembalikan nilai textarea content ke data awal
    postForm.content = props.post.content;
}
</script>

<template>
    <!-- Membungkus seluruh halaman edit dengan Layout utama aplikasi -->
    <Layout>
        <!-- Mengatur judul halaman pada tab browser -->
        <Head title="Edit Post - Tugas Pak Faruq" />

        <!-- Baris Grid Form yang Terpusat dan Proporsional -->
        <div class="row justify-content-center animate-fade-in">
            <!-- Kolom responsif: full di mobile, 10 di tablet, 8 di desktop -->
            <div class="col-12 col-md-10 col-lg-8">
                <!-- Baris Navigasi Kembali dan Judul Halaman -->
                <div class="d-flex align-items-center mb-4 gap-3">
                    <!-- Tombol Kembali Berbentuk Lingkaran dengan Efek Hover -->
                    <Link
                        href="/posts"
                        class="btn btn-white bg-white border shadow-sm rounded-circle p-0 d-flex align-items-center justify-content-center hover-scale"
                        style="width: 44px; height: 44px;"
                        title="Kembali ke Daftar Post"
                    >
                        <!-- Ikon Panah Kiri -->
                        <i class="bi bi-arrow-left fs-5 text-dark"></i>
                    </Link>

                    <!-- Judul dan Keterangan Formulir Edit -->
                    <div>
                        <!-- Judul Form Edit Post -->
                        <h3 class="fw-bold text-dark m-0">Edit Postingan #{{ post.id }}</h3>
                        <!-- Keterangan Formulir -->
                        <p class="text-muted small m-0">
                            Perbarui informasi judul dan konten artikel Anda di bawah ini.
                        </p>
                    </div>
                </div>

                <!-- Kartu Formulir dengan Desain Modern dan Animasi Slide Up -->
                <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden animate-slide-up">
                    <div class="card-body p-4 p-md-5">
                        <!-- Formulir Pengeditan Postingan dengan Event Listener submit.prevent -->
                        <form @submit.prevent="updatePost">
                            <!-- Input Judul Postingan -->
                            <div class="mb-4">
                                <!-- Label Input Judul dan Karakter Counter -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold text-dark m-0">
                                        JUDUL POSTINGAN <span class="text-danger">*</span>
                                    </label>
                                    <span class="badge bg-light text-muted border small">
                                        {{ postForm.title.length }} / 255
                                    </span>
                                </div>

                                <!-- Kolom Input Judul -->
                                <input
                                    type="text"
                                    class="form-control form-control-lg bg-light border-0 rounded-3 fs-6"
                                    :class="{ 'is-invalid': errors?.title }"
                                    v-model="postForm.title"
                                    placeholder="Masukkan Title Post"
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
                                <!-- Label Input Konten dan Penghitung Karakter -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold text-dark m-0">
                                        KONTEN ARTIKEL <span class="text-danger">*</span>
                                    </label>
                                    <span class="badge bg-light text-muted border small">
                                        {{ postForm.content.length }} karakter
                                    </span>
                                </div>

                                <!-- Textarea Input Konten -->
                                <textarea
                                    class="form-control form-control-lg bg-light border-0 rounded-3 fs-6"
                                    rows="6"
                                    :class="{ 'is-invalid': errors?.content }"
                                    v-model="postForm.content"
                                    placeholder="Masukkan Content Post"
                                    required
                                ></textarea>

                                <!-- Pesan Kesalahan Validasi Konten -->
                                <div v-if="errors?.content" class="invalid-feedback mt-1 fw-medium">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ errors.content }}
                                </div>
                            </div>

                            <!-- Baris Tombol Aksi Formulir (Update, Kembalikan, & Batal) Responsif -->
                            <div class="d-flex flex-column flex-sm-row gap-2 pt-2 border-top">
                                <!-- Tombol Submit Pembaruan Data -->
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
                                    <span>{{ isSubmitting ? 'MEMPERBARUI...' : 'UPDATE POST' }}</span>
                                </button>

                                <!-- Tombol Reset / Batalkan Perubahan Form -->
                                <button
                                    type="button"
                                    @click="resetForm"
                                    class="btn btn-light border rounded-pill px-4 py-2-5 text-secondary fw-semibold hover-lift"
                                    :disabled="isSubmitting"
                                >
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> RESET SEMULA
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
