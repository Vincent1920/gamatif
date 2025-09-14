<template>
    <div class="p-8 mt-15" v-if="user">
        <!-- Judul -->
        <h1 class="text-3xl font-bold mb-8 text-gray-800">
            Selamat Datang,
            <span class="text-yellow-600">{{ user.nama_lengkap }}</span> 🎉
        </h1>

        <!-- Grid Bento -->
        <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
            <!-- Kartu Profil -->
            <div
                class="md:col-span-2 bg-white rounded-2xl shadow-sm hover:shadow-md p-6 flex flex-col items-center justify-center transition"
            >
                <img
                    :src="`https://ui-avatars.com/api/?name=${user.nama_lengkap}&background=eab308&color=fff`"
                    class="w-20 h-20 rounded-full mb-4"
                />
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ user.nama_lengkap }}
                </h2>
                <p class="text-sm text-gray-500">NIM: {{ user.nim }}</p>

                <p class="text-sm text-gray-500">
                    Kelompok:
                    <span
                        v-if="user.kelompok"
                        class="text-gray-800 font-medium"
                    >
                        {{ user.kelompok.nama_kelompok }}
                    </span>
                    <span v-else class="text-gray-300"
                        >belum mengambil kelompok</span
                    >
                </p>

                <div class="flex gap-2 mt-4">
                    <button
                        class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600"
                        @click="goToProfile"
                    >
                        Lihat Profil
                    </button>

                    <button
                        v-if="!user.kelompok"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600"
                        @click="goToAmbilKelompok"
                    >
                        Ambil Kelompok
                    </button>
                </div>
            </div>

            <!-- Jadwal -->
            <div
                class="md:col-span-4 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition"
            >
                <h2 class="text-lg font-semibold mb-4 text-gray-800">
                    📅 Jadwal Kegiatan
                </h2>
                <!-- Tampilan Loading -->
                <div v-if="isJadwalLoading" class="text-sm text-gray-500">Memuat jadwal...</div>
                <!-- Tampilan Error -->
                <div v-if="jadwalError" class="text-sm text-red-500">{{ jadwalError }}</div>
                <!-- Tampilan Data -->
                <ul v-else class="space-y-2 text-sm text-gray-700">
                    <li v-for="item in jadwalKegiatan" :key="item.id" class="border-b pb-2">
                        <div class="font-semibold">{{ item.nama }}</div>
                        <div class="text-gray-500">{{ item.tanggal }} | {{ item.waktu_mulai }} - {{ item.waktu_selesai }}</div>
                    </li>
                </ul>
            </div>

            <!-- Pengumuman -->
            <div
                class="md:col-span-3 bg-white rounded-2xl shadow-sm hover:shadow-md p-6 transition"
            >
                <h2 class="text-lg font-semibold mb-4 text-gray-800">
                    📢 Pengumuman
                </h2>
                <div class="space-y-3 text-sm text-gray-600">
                    <p class="border-l-4 border-yellow-400 pl-3">
                        Coming Soon ✨
                    </p>
                </div>
            </div>

            <!-- Sosial Media -->
            <div
                class="md:col-span-3 bg-white rounded-2xl shadow-sm hover:shadow-md p-6 transition"
            >
                <h2 class="text-lg font-semibold mb-4 text-gray-800">
                    📲 Jangan Lupa Follow Yaa!!
                </h2>
                <!-- Tampilan Loading -->
                <div v-if="isSosmedLoading" class="text-sm text-gray-500">Memuat link...</div>
                <!-- Tampilan Error -->
                <div v-if="sosmedError" class="text-sm text-red-500">{{ sosmedError }}</div>
                
                <!-- Tampilan Data -->
                <div v-else class="space-y-3 text-sm">
                    <a v-for="item in sosialMedia" :key="item.id" :href="item.url" target="_blank" 
                       class="block border-l-4 border-yellow-500 bg-gray-100 dark:bg-gray-800 px-4 py-2 rounded-r-md text-gray-700 dark:text-gray-300 hover:bg-yellow-100 dark:hover:bg-gray-700 transition font-medium">
                        {{ item.nama }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/Stores/authStore";
import { useJadwalKegiatanStore } from "@/Stores/jadwalKegiatanStore";
import { useSosialMediaStore } from "@/Stores/sosialMediaStore";

const router = useRouter();

// Main Auth Store
const authStore = useAuthStore();
const { user, isAuthenticated } = storeToRefs(authStore);

// Jadwal Kegiatan Store
const jadwalStore = useJadwalKegiatanStore();
const { jadwalKegiatan, isLoading: isJadwalLoading, error: jadwalError } = storeToRefs(jadwalStore);

// Sosial Media Store
const sosmedStore = useSosialMediaStore();
const { sosialMedia, isLoading: isSosmedLoading, error: sosmedError } = storeToRefs(sosmedStore);

onMounted(async () => {
    // Coba auto login
    if (!user.value) {
        await authStore.tryAutoLogin();
    }

    // Redirect jika tidak login
    if (!isAuthenticated.value) {
        router.push("/login");
    } else {
        // Ambil data dari API jika sudah login
        jadwalStore.fetchJadwalKegiatan();
        sosmedStore.fetchSosialMedia();
    }
});

const goToProfile = () => {
    router.push("/profile-maba");
};

const goToAmbilKelompok = () => {
    router.push("/ambil-kelompok");
};
</script>

