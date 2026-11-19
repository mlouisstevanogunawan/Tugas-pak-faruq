<script setup>
// Mengimpor komponen Layout utama dari Layouts/App.vue
import Layout from '../../Layouts/App.vue';
// Mengimpor Link dan router dari Inertia.js untuk Vue 3
import { Link, router, Head } from '@inertiajs/vue3';
// Mengimpor ref dan computed dari Vue 3
import { ref, computed } from 'vue';

// Mendefinisikan properti 'posts' yang diterima dari controller
const props = defineProps({
    // posts bertipe Array
    posts: {
        type: Array,
        default: () => [],
    },
});

// State reaktif pencarian
const searchQuery = ref('');

// Computed property untuk memfilter daftar postingan
const filteredPosts = computed(() => {
    if (!searchQuery.value.trim()) {
        return props.posts;
    }
    const q = searchQuery.value.toLowerCase();
    return props.posts.filter((p) => {
        return (p.title && p.title.toLowerCase().includes(q)) || (p.content && p.content.toLowerCase().includes(q));
    });
});

// Fungsi untuk menghapus post dengan konfirmasi
function deletePost(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data post ini?')) {
        router.delete(`/posts/${id}`);
    }
}
</script>

<template>
    <!-- Membungkus dengan Layout utama aplikasi -->
    <Layout>
        <!-- Mengatur judul halaman -->
        <Head title="Data Posts - Tugas Pak Faruq" />

        <div class="row g-4 animate-fade-in">
            <div class="col-12">
                <!-- Header Atas Halaman -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                    <div>
                        <h2 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-text text-primary"></i>
                            <span>Data Posts</span>
                        </h2>
                        <p class="text-muted small m-0 mt-1">Kelola seluruh postingan artikel Anda di sini.</p>
                    </div>

                    <div>
                        <Link
                            href="/posts/create"
                            class="btn btn-gradient-primary rounded-pill px-4 py-2-5 shadow-sm d-inline-flex align-items-center gap-2 hover-lift w-100 w-sm-auto justify-content-center"
                        >
                            <i class="bi bi-plus-circle-fill"></i>
                            <span class="fw-bold">TAMBAH DATA</span>
                        </Link>
                    </div>
                </div>

                <!-- Kolom Pencarian -->
                <div class="card border-0 rounded-4 shadow-sm mb-4 bg-white">
                    <div class="card-body p-3 p-md-4">
                        <div class="row align-items-center g-3">
                            <div class="col-12 col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-muted">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control bg-light border-start-0 rounded-end-pill py-2"
                                        placeholder="Cari postingan..."
                                        v-model="searchQuery"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-md-4 text-md-end">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold">
                                    Total: {{ filteredPosts.length }} Post
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tampilan Tabel Desktop -->
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden bg-white d-none d-md-block">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-secondary fs-7 fw-bold" style="width: 60px;">NO</th>
                                        <th scope="col" class="px-4 py-3 text-secondary fs-7 fw-bold">TITLE</th>
                                        <th scope="col" class="px-4 py-3 text-secondary fs-7 fw-bold">CONTENT</th>
                                        <th scope="col" class="px-4 py-3 text-secondary fs-7 fw-bold text-end" style="width: 180px;">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!filteredPosts || filteredPosts.length === 0">
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50 animate-float"></i>
                                            <span>Belum ada data post. Silakan tambah data baru!</span>
                                        </td>
                                    </tr>
                                    <tr v-for="(post, idx) in filteredPosts" :key="post.id">
                                        <td class="px-4 py-3 text-muted fw-medium">{{ idx + 1 }}</td>
                                        <td class="px-4 py-3 fw-bold text-dark">{{ post.title }}</td>
                                        <td class="px-4 py-3 text-secondary text-truncate" style="max-width: 320px;">{{ post.content }}</td>
                                        <td class="px-4 py-3 text-end">
                                            <div class="d-inline-flex gap-2">
                                                <Link :href="`/posts/${post.id}/edit`" class="btn btn-sm btn-outline-primary rounded-pill px-3 hover-lift">
                                                    <i class="bi bi-pencil-square"></i> EDIT
                                                </Link>
                                                <button @click.prevent="deletePost(post.id)" class="btn btn-sm btn-outline-danger rounded-pill px-3 hover-lift">
                                                    <i class="bi bi-trash"></i> DELETE
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tampilan Kartu Mobile -->
                <div class="d-block d-md-none d-flex flex-column gap-3">
                    <div v-if="!filteredPosts || filteredPosts.length === 0" class="card border-0 rounded-4 shadow-sm p-5 text-center bg-white">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                        <span class="text-muted">Belum ada data post.</span>
                    </div>

                    <div v-for="post in filteredPosts" :key="post.id" class="card border-0 rounded-4 shadow-sm p-3 bg-white post-mobile-card">
                        <h5 class="fw-bold text-dark mb-2">{{ post.title }}</h5>
                        <p class="text-secondary small mb-3">{{ post.content }}</p>
                        <div class="d-flex gap-2 pt-2 border-top">
                            <Link :href="`/posts/${post.id}/edit`" class="btn btn-sm btn-outline-primary rounded-pill flex-grow-1 py-2 text-center">
                                EDIT
                            </Link>
                            <button @click.prevent="deletePost(post.id)" class="btn btn-sm btn-outline-danger rounded-pill flex-grow-1 py-2 text-center">
                                DELETE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
