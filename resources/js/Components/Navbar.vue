<template>
    <nav
        :class="[
            'fixed w-full z-20 top-0 start-0 border-b transition-colors duration-300',
            isScrolled
                ? 'bg-white border-gray-200 shadow-sm'
                : 'bg-transparent border-transparent',
        ]"
    >
        <div
            class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4"
        >
            <router-link
                to="/"
                class="flex items-center space-x-3 rtl:space-x-reverse"
            >
                <img :src="logoGamatifUrl" class="h-10" alt="Gamatif Logo" />
            </router-link>

            <div
                v-if="isAuthenticated"
                class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse"
            >
                <div class="relative">
                    <!-- Tombol avatar -->
                    <button
                        @click="isDropdownOpen = !isDropdownOpen"
                        type="button"
                        class="flex items-center text-sm bg-white border border-gray-200 rounded-full shadow-sm hover:shadow-md transition px-2 py-1 focus:ring-2 focus:ring-yellow-300"
                    >
                        <img
                            class="w-8 h-8 rounded-full"
                            :src="`https://ui-avatars.com/api/?name=${user.nama_lengkap}&background=eab308&color=fff`"
                            alt="user photo"
                        />
                        <span
                            class="hidden md:block ml-3 text-gray-700 font-medium"
                        >
                            {{ shortName }}
                        </span>
                        <svg
                            class="w-4 h-4 ml-2 text-gray-500"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div
                        v-if="isDropdownOpen"
                        class="absolute right-0 mt-2 z-50 w-52 bg-white border border-gray-200 rounded-lg shadow-md"
                    >
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-800">
                                {{ user.nama_lengkap }}
                            </p>
                            <p class="text-sm text-gray-500 truncate">
                                {{ user.email }}
                            </p>
                        </div>
                        <ul class="py-2 text-sm text-gray-700">
                            <li>
                                <router-link
                                    to="/"
                                    @click="isDropdownOpen = false"
                                    class="block px-4 py-2 hover:bg-gray-50 transition"
                                    >Beranda</router-link
                                >
                            </li>
                            <li>
                                <router-link
                                    to="/dashboard-maba"
                                    @click="isDropdownOpen = false"
                                    class="block px-4 py-2 hover:bg-gray-50 transition"
                                    >Dashboard</router-link
                                >
                            </li>
                            <li class="flex justify-center">
                                <hr class="my-1 w-43 text-gray-300" />
                            </li>
                            <li>
                                <router-link
                                    to="/profile-maba"
                                    @click="isDropdownOpen = false"
                                    class="block px-4 py-2 hover:bg-gray-50 transition"
                                    >Profile</router-link
                                >
                            </li>
                            <li>
                                <button
                                    @click="handleLogout"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-50 transition"
                                >
                                    Logout
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div
                v-else
                class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse"
            >
                <router-link
                    to="/login-maba"
                    class="text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-4 py-2 text-center"
                >
                    Login
                </router-link>
            </div>

            <div
                class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1"
                id="navbar-sticky"
            >
                <ul
                    class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0"
                >
                    <template v-if="isAuthenticated">
                        <li>
                            <router-link
                                to="/"
                                class="block py-2 px-3 rounded"
                                active-class="text-yellow-500"
                                :class="{
                                    'text-gray-500': $route.path !== '/',
                                    'text-gray-500': $route.path === '/',
                                }"
                                >Beranda</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                to="/dashboard-maba"
                                class="block py-2 px-3 rounded"
                                active-class="text-yellow-500"
                                :class="{
                                    'text-gray-500':
                                        $route.path !== '/dashboard-maba',
                                    'text-gray-500':
                                        $route.path === '/dashboard-maba',
                                }"
                                >Dashboard</router-link
                            >
                        </li>
                    </template>
                    <template v-else>
                        <li>
                            <a
                                href="#beranda"
                                active-class="text-yellow-500"
                                @click.prevent="scrollTo('beranda')"
                                class="block py-2 px-3"
                                >Beranda</a
                            >
                        </li>
                        <li>
                            <a
                                href="#tentang"
                                active-class="text-yellow-500"
                                @click.prevent="scrollTo('tentang')"
                                class="block py-2 px-3"
                                >Tentang</a
                            >
                        </li>
                        <li>
                            <a
                                href="#kontak"
                                active-class="text-yellow-500"
                                @click.prevent="scrollTo('kontak')"
                                class="block py-2 px-3"
                                >Kontak</a
                            >
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import { storeToRefs } from "pinia";
import { useRouter, RouterLink } from "vue-router";
import { useAuthStore } from "@/Stores/authStore";
import { usePengaturanWebStore } from "@/Stores/pengaturanWebStore";

const pengaturanWebStore = usePengaturanWebStore();
const { pengaturanWeb } = storeToRefs(pengaturanWebStore);

onMounted(() => {
    pengaturanWebStore.fetchPengaturanWeb();
});

const baseURL = window.location.origin;

// Buat computed biar rapi
const logoGamatifUrl = computed(() => {
    if (pengaturanWeb.value[0]?.logo_gamatif) {
        return `${baseURL}/storage/${pengaturanWeb.value[0].logo_gamatif}`;
    }
    return "/images/logo-gamatif.png"; // fallback default
});

const router = useRouter();
const authStore = useAuthStore();

// Ambil state dan getter dari store untuk menjaga reaktivitas
const { isAuthenticated, user } = storeToRefs(authStore);

// State lokal untuk mengontrol visibilitas dropdown
const isDropdownOpen = ref(false);

const isScrolled = ref(false);

const shortName = computed(() => {
    if (!user.value?.nama_lengkap) return "";
    return user.value.nama_lengkap.split(" ").slice(0, 1).join(" ");
});
const handleScroll = () => {
    isScrolled.value = window.scrollY > 10; // jika scroll lebih dari 10px
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});
// Fungsi untuk scroll di landing page (hanya untuk guest/tamu)
async function scrollTo(id) {
    if (router.currentRoute.value.path !== "/") {
        await router.push("/"); // arahkan ke halaman utama dulu
        // tunggu DOM ter-render
        setTimeout(() => {
            const el = document.getElementById(id);
            if (el) el.scrollIntoView({ behavior: "smooth" });
        }, 300);
    } else {
        const el = document.getElementById(id);
        if (el) el.scrollIntoView({ behavior: "smooth" });
    }
}

// Fungsi untuk menangani proses logout
const handleLogout = () => {
    authStore.logout();
    isDropdownOpen.value = false; // Tutup dropdown setelah logout
    router.push("/"); // Arahkan pengguna kembali ke halaman login
};
</script>
