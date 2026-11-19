// Mengimpor file stylesheet utama CSS aplikasi yang berisi styling kustom dan animasi
import '../css/app.css';

// Mengimpor file inisialisasi bootstrap untuk konfigurasi dasar Axios dan HTTP client
import './bootstrap';

// Mengimpor fungsi createInertiaApp dari Inertia.js untuk inisialisasi aplikasi Vue berbasis SPA
import { createInertiaApp } from '@inertiajs/vue3';

// Mengimpor helper dari plugin Laravel Vite untuk meresolusi komponen halaman secara dinamis
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

// Mengimpor createApp untuk membuat instance aplikasi Vue dan fungsi h untuk membuat virtual DOM node
import { createApp, h } from 'vue';

// Mengimpor plugin ZiggyVue agar fungsi rute route() dari Laravel dapat digunakan di dalam komponen Vue
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// Mengambil variabel nama aplikasi dari file konfigurasi environment (.env) atau default 'Tugas Pak Faruq'
const appName = import.meta.env.VITE_APP_NAME || 'Tugas Pak Faruq';

// Menginisialisasi aplikasi Inertia.js dengan konfigurasi judul, resolusi komponen, dan setup Vue
createInertiaApp({
    // Mengatur pola judul halaman tab browser: "<Judul Halaman> - <Nama Aplikasi>"
    title: (title) => (title ? `${title} - ${appName}` : appName),

    // Resolusi otomatis file komponen Vue berdasarkan path nama halaman dari Controller Laravel
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            // Memuat seluruh file .vue di dalam direktori ./Pages secara lazy loading via Vite
            import.meta.glob('./Pages/**/*.vue'),
        ),

    // Fungsi setup untuk mengkonfigurasi dan me-mount aplikasi Vue ke elemen root DOM (#app)
    setup({ el, App, props, plugin }) {
        // Membuat instance aplikasi Vue baru menggunakan render function h(App, props)
        return createApp({ render: () => h(App, props) })
            // Mengaktifkan plugin Inertia.js pada Vue
            .use(plugin)
            // Mengaktifkan plugin Ziggy untuk integrasi rute Laravel di frontend
            .use(ZiggyVue)
            // Memasang (mount) aplikasi Vue ke dalam elemen DOM HTML (id #app)
            .mount(el);
    },

    // Konfigurasi indikator loading bar (progress bar) bawaan Inertia saat berpindah halaman
    progress: {
        // Warna garis loading bar di bagian atas layar (indigo modern)
        color: '#6366f1',
        // Menampilkan spinner kecil di sudut layar saat proses loading berlangsung
        showSpinner: true,
    },
});
