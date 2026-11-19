{{-- Mendefinisikan dokumen sebagai standar HTML5 modern --}}
<!DOCTYPE html>
{{-- Mengatur atribut bahasa dokumen web secara dinamis berdasarkan konfigurasi aplikasi Laravel --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- Menentukan encoding karakter dokumen menggunakan standar UTF-8 --}}
        <meta charset="utf-8">
        {{-- Konfigurasi viewport agar halaman web tampil responsif dan proporsional di seluruh ukuran layar perangkat --}}
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Mengatur judul tab browser dengan dukungan dinamis dari Inertia.js --}}
        <title inertia>{{ config('app.name', 'Tugas Pak Faruq - Laravel Inertia') }}</title>

        {{-- Melakukan preconnect ke server font Google untuk mempercepat waktu pemuatan font --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        {{-- Melakukan preconnect ke server aset statis Google Fonts dengan dukungan CORS --}}
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        {{-- Memuat font tipografi modern 'Plus Jakarta Sans' dengan berbagai ketebalan font --}}
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        {{-- Memuat pustaka CSS framework Bootstrap 5.3 melalui jaringan CDN berkecepatan tinggi --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        {{-- Memuat pustaka ikon resmi Bootstrap Icons untuk memperkaya tampilan UI --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        {{-- Menyuntikkan helper rute Ziggy ke dalam JavaScript browser sehingga fungsi route() dapat digunakan di Vue --}}
        @routes
        {{-- Memuat dan mengompilasi bundel JavaScript utama serta komponen halaman Vue yang aktif melalui Vite --}}
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        {{-- Menyuntikkan elemen head (meta tag, title, dll.) yang didefinisikan secara dinamis oleh komponen Vue Inertia --}}
        @inertiaHead
    </head>
    {{-- Elemen body dengan kelas antialiased agar font tampak lebih halus dan tajam di layar --}}
    <body class="antialiased">
        {{-- Direktif utama Inertia untuk menyisipkan elemen root tempat aplikasi Vue dimounting --}}
        @inertia

        {{-- Memuat pustaka JavaScript Bootstrap 5.3 beserta Popper.js melalui CDN --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
