<template>
    <div class="min-h-screen flex">
        <!-- Left Side (Brand / Illustration) -->
        <div
            class="hidden lg:flex w-1/2 bg-gradient-to-br from-yellow-400 to-yellow-600 text-white items-center justify-center"
        >
            <div class="text-center px-10">
                <h1 class="text-5xl font-extrabold mb-4 drop-shadow-lg">
                    Selamat Datang
                </h1>
                <p class="text-lg opacity-90">
                    Mahasiswa Baru Teknik Informatika
                </p>
                <!-- <img
                    src="../../../../public/images/maskot.png"
                    alt="Illustration"
                    class="mt-10 max-w-md mx-auto"
                /> -->
            </div>
        </div>

        <!-- Right Side (Login Form) -->
        <div class="flex-1 flex items-center justify-center bg-gray-50">
            <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">
                    Login Mahasiswa
                </h2>

                <!-- Error Message -->
                <div
                    v-if="error"
                    class="mb-4 p-3 bg-red-100 text-red-700 text-sm rounded-md"
                >
                    {{ error }}
                </div>

                <form @submit.prevent="handleLogin" class="space-y-5">
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Email
                        </label>
                        <input
                            v-model="email"
                            type="email"
                            id="email"
                            required
                            placeholder="contoh@mahasiswa.unikom.ac.id"
                            class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        />
                    </div>

                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Password
                        </label>
                        <input
                            v-model="password"
                            type="password"
                            id="password"
                            required
                            placeholder="••••••••"
                            class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        />
                    </div>

                    <button
                        type="submit"
                        :disabled="loading"
                        class="w-full py-3 px-4 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow-md transition disabled:opacity-50"
                    >
                        {{ loading ? "Memproses..." : "Login" }}
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500">
                    Belum punya akun?
                    <a
                        href="/registrasi-maba"
                        class="text-yellow-600 hover:underline font-medium"
                        >Registrasi</a
                    >
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../../Stores/authStore";
import { storeToRefs } from "pinia";

const router = useRouter();
const authStore = useAuthStore();

// Ambil isLoading dari store untuk menonaktifkan tombol
const { isLoading } = storeToRefs(authStore);

// State lokal untuk form dan pesan error di halaman ini
const email = ref("");
const password = ref("");
const error = ref("");

const handleLogin = async () => {
    error.value = ""; // Reset pesan error setiap kali login dicoba

    // Panggil action 'login' dari store
    const success = await authStore.login({
        email: email.value,
        password: password.value,
    });

    if (success) {
        // Jika login berhasil, redirect ke halaman dashboard (atau halaman lain)
        router.push("/dashboard-maba"); // Ganti '/dashboard-maba' dengan rute tujuan Anda
    } else {
        // Jika login gagal, tampilkan pesan error dari store
        if (authStore.errors.general) {
            error.value = authStore.errors.general[0];
        } else {
            error.value = "Terjadi kesalahan yang tidak diketahui.";
        }
    }
};
</script>
