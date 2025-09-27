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
                <div v-if="isPengaturanLoading">
                    <SkeletonLoader customClass="h-10 w-10" />
                </div>
                <img
                    v-else
                    :src="logoGamatifUrl"
                    class="h-10"
                    alt="Gamatif Logo"
                    loading="lazy"
                />
            </router-link>

            <div
                v-if="isAuthenticated"
                class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse"
            >
                <div class="relative" ref="profileDropdownRef">
                    <button
                        @click="isDropdownOpen = !isDropdownOpen"
                        type="button"
                        class="flex items-center text-sm bg-white border border-gray-200 rounded-full shadow-sm hover:shadow-md transition px-2 py-1 focus:ring-2 focus:ring-yellow-300 cursor-pointer"
                    >
                        <img
                            class="w-8 h-8 rounded-full"
                            :src="`https://ui-avatars.com/api/?name=${user.nama_lengkap}&background=eab308&color=fff`"
                            alt="user photo"
                            loading="lazy"
                        />
                        <span
                            class="hidden md:block ml-3 text-gray-700 font-medium "
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

                    <div
                        v-if="isDropdownOpen"
                        class="absolute right-0 mt-2 z-50 w-52 bg-white border border-gray-200 rounded-lg shadow-lg"
                    >
                        <div
                            class="px-4 py-3 border-b border-gray-100"
                        >
                            <p
                                class="text-sm font-semibold text-gray-800 "
                            >
                                {{ user.nama_lengkap }}
                            </p>
                            <p
                                class="text-sm text-gray-500 truncate "
                            >
                                {{ user.email }}
                            </p>
                        </div>
                        <ul
                            class="py-2 text-sm text-gray-700 "
                        >
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
                            <li>
                                <router-link
                                    to="/menfess"
                                    class="block px-4 py-2 hover:bg-gray-50 transition"
                                    @click="isDropdownOpen = false"
                                    >Gamafess</router-link
                                >
                            </li>
                            <li class="px-4">
                                <hr
                                    class="my-1 border-gray-200"
                                />
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
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-50 transition cursor-pointer"
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
                    class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 text-gray-700 "
                >
                    <template v-if="isAuthenticated">
                        <li>
                            <router-link
                                to="/"
                                class="block py-2 px-3 rounded hover:text-yellow-500"
                                active-class="text-yellow-500"
                                >Beranda</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                to="/dashboard-maba"
                                class="block py-2 px-3 rounded hover:text-yellow-500"
                                active-class="text-yellow-500"
                                >Dashboard</router-link
                            >
                        </li>
                        <li>
                            <router-link
                                to="/menfess"
                                class="block py-2 px-3 rounded hover:text-yellow-500"
                                active-class="text-yellow-500"
                                >Gamafess</router-link
                            >
                        </li>
                    </template>
                    <template v-else>
                        <li>
                            <a
                                href="#beranda"
                                @click.prevent="scrollTo('beranda')"
                                class="block py-2 px-3 hover:text-yellow-500"
                                >Beranda</a
                            >
                        </li>
                        <li>
                            <a
                                href="#tentang"
                                @click.prevent="scrollTo('tentang')"
                                class="block py-2 px-3 hover:text-yellow-500"
                                >Tentang</a
                            >
                        </li>
                        <li>
                            <a
                                href="#kontak"
                                @click.prevent="scrollTo('kontak')"
                                class="block py-2 px-3 hover:text-yellow-500"
                                >Kontak</a
                            >
                        </li>
                        <li>
                            <router-link
                                to="/menfess"
                                class="block py-2 px-3 rounded hover:text-yellow-500"
                                active-class="text-yellow-500"
                                >Gamafess</router-link
                            >
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from "vue";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/Stores/authStore";
import { usePengaturanWebStore } from "@/Stores/pengaturanWebStore";
import SkeletonLoader from "@/Components/SkeletonLoader.vue";

// --- State & Stores ---
const pengaturanWebStore = usePengaturanWebStore();
const { pengaturanWeb, isLoading: isPengaturanLoading } =
    storeToRefs(pengaturanWebStore);
const router = useRouter();
const authStore = useAuthStore();
const { isAuthenticated, user } = storeToRefs(authStore);

// State lokal
const isDropdownOpen = ref(false);
const isScrolled = ref(false);
const profileDropdownRef = ref(null); // Ref untuk elemen dropdown wrapper

const baseURL = window.location.origin;

// --- Computed Properties ---
const logoGamatifUrl = computed(() => {
    if (pengaturanWeb.value[0]?.logo_gamatif) {
        return `${baseURL}/storage/${pengaturanWeb.value[0].logo_gamatif}`;
    }
    return "/images/logo-gamatif.png"; // fallback
});

const shortName = computed(() => {
    if (!user.value?.nama_lengkap) return "";
    return user.value.nama_lengkap.split(" ")[0]; // Ambil nama pertama
});

// --- Functions ---
async function scrollTo(id) {
    if (router.currentRoute.value.path !== "/") {
        await router.push("/");
        setTimeout(() => {
            const el = document.getElementById(id);
            if (el) el.scrollIntoView({ behavior: "smooth" });
        }, 300);
    } else {
        const el = document.getElementById(id);
        if (el) el.scrollIntoView({ behavior: "smooth" });
    }
}

const handleLogout = () => {
    authStore.logout();
    isDropdownOpen.value = false;
    router.push("/");
};

// --- Lifecycle & Event Listeners ---
const handleScroll = () => {
    isScrolled.value = window.scrollY > 10;
};

const handleClickOutside = (event) => {
    // Jika dropdown terbuka dan klik terjadi di luar elemen dropdown
    if (
        isDropdownOpen.value &&
        profileDropdownRef.value &&
        !profileDropdownRef.value.contains(event.target)
    ) {
        isDropdownOpen.value = false;
    }
};

// Gunakan `watch` untuk mengelola event listener secara efisien
watch(isDropdownOpen, (isOpen) => {
    if (isOpen) {
        // Tambahkan listener saat dropdown dibuka
        document.addEventListener("mousedown", handleClickOutside);
    } else {
        // Hapus listener saat dropdown ditutup
        document.removeEventListener("mousedown", handleClickOutside);
    }
});

onMounted(() => {
    pengaturanWebStore.fetchPengaturanWeb();
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    // Pastikan semua listener dibersihkan saat komponen dihancurkan
    window.removeEventListener("scroll", handleScroll);
    document.removeEventListener("mousedown", handleClickOutside);
});
</script>
