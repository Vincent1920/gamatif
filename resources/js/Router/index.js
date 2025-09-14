import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../Stores/authStore";

import LandingPage from "../Pages/Public/LandingPage.vue";
import RegisterPage from "../Pages/Auth/Register.vue";
import LoginPage from "../Pages/Auth/Login.vue";
import DashboardMabaPage from "../Pages/Profile/DashboardMaba.vue";
import ProfilePage from "../Pages/Profile/DetailProfile.vue";


const routes = [
    {
        path: "/", // Path URL di browser
        name: "landing", // Nama rute (opsional, tapi praktik yang baik)
        component: LandingPage, // Komponen Vue yang akan ditampilkan
    },
    {
        path: "/registrasi-maba",
        name: "registrasi",
        component: RegisterPage,
    },

    {
        path: "/login-maba",
        name: "login",
        component: LoginPage,
    },

    {
        path: "/dashboard-maba",
        name: "dashboard",
        component: DashboardMabaPage,
    },
    {
        path: "/profile-maba",
        name: "profile",
        component: ProfilePage,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next({ name: "login" }); // Alihkan jika butuh login & belum login
    } else {
        next(); // Lanjutkan jika tidak butuh login ATAU sudah login
    }
});

export default router;
