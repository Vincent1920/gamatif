import { createRouter, createWebHistory } from 'vue-router';

// 1. Impor komponen halaman yang akan digunakan
import LandingPage from '../Pages/Public/LandingPage.vue';

// 2. Definisikan rute-rute Anda
const routes = [
    {
        path: '/', // Path URL di browser
        name: 'landing', // Nama rute (opsional, tapi praktik yang baik)
        component: LandingPage, // Komponen Vue yang akan ditampilkan
    },
    // --- Tambahkan rute lain di sini nanti ---
    // Contoh:
    // {
    //     path: '/login',
    //     name: 'login',
    //     component: () => import('./Pages/Auth/LoginPage.vue'),
    // },
];

// 3. Buat instance router
const router = createRouter({
    history: createWebHistory(), // Menggunakan mode histori HTML5 (URL bersih)
    routes, // Memuat rute yang sudah didefinisikan
});

// 4. Ekspor router agar bisa digunakan di app.js
export default router;