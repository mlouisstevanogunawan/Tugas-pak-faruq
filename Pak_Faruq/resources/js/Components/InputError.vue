<script setup>
// Mendefinisikan properti message yang akan menampilkan teks pesan error validasi
defineProps({
    // message bertipe string yang opsional
    message: {
        type: String,
    },
});
</script>

<template>
    <!-- Menampilkan pesan error hanya jika message ada nilainya (v-show) -->
    <div v-show="message" class="text-danger small mt-1 d-flex align-items-center gap-1 animate-fade-in">
        <!-- Ikon peringatan segitiga -->
        <i class="bi bi-exclamation-triangle-fill"></i>
        <!-- Teks pesan kesalahan validasi -->
        <span>{{ message }}</span>
    </div>
</template>
