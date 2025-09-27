<template>
    <section class="max-w-lg mx-auto mt-12">
        <div class="bg-white p-8 rounded-2xl shadow-xl">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-pink-500">Kirim Pesan Rahasia</h2>
                <router-link
                to="/menfess"
                class=" top-4 right-4 bg-gray-100 hover:bg-gray-200 text-gray-600 p-2 rounded-full transition download-ignore"
            >
                x
            </router-link>
            </div>
            <form @submit.prevent="submitMenfess">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold">Untuk:</label>
                    <p class="text-xs text-pink mt-1 mb-2">Mention instagramnya yuk >.<</p>
                    <input type="text" v-model="form.to" class="w-full px-4 py-3 rounded-lg bg-gray-100 border-2 border-transparent focus:border-pink-400 focus:bg-white focus:outline-none transition" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Pesanmu:</label>
                    <textarea v-model="form.message" rows="5" class="w-full px-4 py-3 rounded-lg bg-gray-100 border-2 border-transparent focus:border-pink-400 focus:bg-white focus:outline-none transition" required></textarea>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Dari: (Opsional)</label>
                    <input type="text" v-model="form.from" class="w-full px-4 py-3 rounded-lg bg-gray-100 border-2 border-transparent focus:border-pink-400 focus:bg-white focus:outline-none transition">
                </div>
                <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-6 rounded-full shadow-lg transform hover:scale-105 transition-transform duration-300 ease-in-out flex items-center justify-center">
                    <i data-lucide="send" class="mr-2"></i> Kirim Sekarang
                </button>
            </form>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useMenfessStore } from '@/Stores/menfessStore';

const router = useRouter();
const menfessStore = useMenfessStore();
const form = ref({
    to: '',
    message: '',
    from: ''
});

const submitMenfess = async () => {
    const payload = { ...form.value };
    if (!payload.from) {
        payload.from = 'Anonymous';
    }

    try {
        await menfessStore.createMenfess(payload);
        alert('Menfess berhasil dikirim!');
        router.push('/menfess');
    } catch (error) {
        alert('Gagal mengirim menfess: ' + error.message);
    }
};
</script>
