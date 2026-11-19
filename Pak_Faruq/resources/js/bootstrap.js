// Mengimpor pustaka HTTP client Axios untuk melakukan AJAX / HTTP request
import axios from 'axios';

// Mendaftarkan objek axios ke dalam lingkup global window agar dapat diakses di mana saja
window.axios = axios;

// Mengatur header default X-Requested-With agar setiap request teridentifikasi sebagai XMLHttpRequest (AJAX) oleh backend Laravel
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
