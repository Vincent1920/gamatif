<template>
    <!-- PERBAIKAN: Menambahkan satu div pembungkus untuk mengatasi warning Vite -->
    <div>
        <!-- Elemen section luar sekarang hanya untuk layout -->
        <section v-if="menfessStore.currentMenfess" class="max-w-2xl mx-auto mt-12">
            <div ref="menfessCard" class="bg-white p-8 rounded-2xl shadow-xl relative">
                <router-link
                    to="/menfess"
                    class="absolute top-4 right-4 bg-gray-100 hover:bg-gray-200 text-gray-600 p-2 rounded-full transition download-ignore"
                >
                    x
                </router-link>
                <div class="mt-8 text-center">
                    <p class="text-gray-500 text-lg">Pesan untuk</p>
                    <h2 class="text-4xl font-bold text-pink-500 my-2 break-words">
                        {{ menfessStore.currentMenfess.to }}
                    </h2>
                    <p class="text-2xl text-gray-700 my-8 leading-relaxed break-words">
                        “{{ menfessStore.currentMenfess.message }}”
                    </p>
                    <p class="text-xl text-gray-500 font-semibold break-words">
                        — {{ menfessStore.currentMenfess.from }}
                    </p>
                    <p class="text-sm text-gray-400 mt-4">
                        {{ formatDate(menfessStore.currentMenfess.created_at) }}
                    </p>
                </div>
                
                <!-- Div untuk tombol yang akan terlihat di web -->
                <div
                    class="web-display mt-10 pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-4 justify-center"
                >
                    <button
                        @click="shareToStory"
                        type="button"
                        class="inline-flex items-center justify-center w-full sm:w-auto text-white bg-gradient-to-r from-purple-500 to-pink-500 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-200 font-medium rounded-lg text-sm px-5 py-2.5"
                    >
                        Story-kan
                    </button>
                    <button
                        @click="downloadAsImage"
                        type="button"
                        class="inline-flex items-center justify-center w-full sm:w-auto text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5"
                    >
                        Unduh
                    </button>
                </div>

                <!-- Div untuk branding GAMAFESS, hanya terlihat saat diunduh (hidden by default) -->
                <div class="download-display hidden mt-10 pt-6 border-t border-gray-200 text-center">
                     <h1 class="font-comic text-4xl text-pink-500 font-bold drop-shadow-md">GAMAFESS</h1>
                </div>
            </div>
        </section>
        <div v-else class="text-center mt-12"><p>Memuat detail menfess...</p></div>
    </div>
</template>

<script setup>
import { onMounted, ref, nextTick } from "vue";
import { useRoute } from "vue-router";
import { useMenfessStore } from "@/Stores/menfessStore";
import { toPng, toBlob } from 'html-to-image';

const route = useRoute();
const menfessStore = useMenfessStore();
const menfessCard = ref(null);

// Fungsi untuk memfilter elemen (seperti tombol 'x') agar tidak ikut di gambar
const imageFilter = (element) => {
    return (element.classList ? !element.classList.contains('download-ignore') : true);
};

// Fungsi untuk membuat gambar dari elemen HTML
const generateImage = async (outputType = 'png') => {
    if (!menfessCard.value) return null;
    
    const node = menfessCard.value;
    const webDisplay = node.querySelector('.web-display');
    const downloadDisplay = node.querySelector('.download-display');

    // Tukar visibilitas elemen sebelum membuat gambar
    if (webDisplay) webDisplay.classList.add('hidden');
    if (downloadDisplay) downloadDisplay.classList.remove('hidden');

    let generatedImage = null;

    try {
        // PERBAIKAN: Menunggu DOM selesai diperbarui sebelum membuat gambar
        await nextTick();

        const options = {
            quality: 1.0,
            pixelRatio: 2,
            width: node.offsetWidth,
            height: node.offsetHeight,
            filter: imageFilter, // Menambahkan filter untuk tombol 'x'
            // PERBAIKAN: Menambahkan baseUrl untuk mengatasi error 404 pada resource CSS
            baseUrl: window.location.href
        };

        if (outputType === 'blob') {
            generatedImage = await toBlob(node, options);
        } else {
            generatedImage = await toPng(node, options);
        }
    } catch(err) {
        console.error("Gagal membuat gambar:", err);
    } finally {
        // Kembalikan visibilitas seperti semula setelah selesai, apa pun yang terjadi
        if (webDisplay) webDisplay.classList.remove('hidden');
        if (downloadDisplay) downloadDisplay.classList.add('hidden');
    }

    return generatedImage;
};

// Fungsi untuk mengunduh gambar (untuk desktop atau fallback)
const downloadAsImage = async () => {
    const dataUrl = await generateImage('png');
    if (!dataUrl) {
        alert("Maaf, terjadi kesalahan saat mencoba membuat gambar.");
        return;
    }

    const link = document.createElement('a');
    const fileName = `menfess-untuk-${menfessStore.currentMenfess.to.replace(/\s/g, '-')}.png`;
    
    link.href = dataUrl;
    link.download = fileName;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

// Fungsi baru untuk berbagi ke Story (khusus mobile)
const shareToStory = async () => {
    const blob = await generateImage('blob');
    if (!blob) {
        alert("Maaf, terjadi kesalahan saat mencoba membuat gambar untuk dibagikan.");
        return;
    }

    const fileName = `menfess-untuk-${menfessStore.currentMenfess.to.replace(/\s/g, '-')}.png`;
    const file = new File([blob], fileName, { type: 'image/png' });
    
    if (navigator.canShare && navigator.canShare({ files: [file] })) {
        try {
            await navigator.share({
                files: [file],
                title: `Menfess untuk ${menfessStore.currentMenfess.to}`,
                text: 'Lihat menfess ini!',
            });
        } catch (error) {
            console.error("Gagal berbagi:", error);
        }
    } else {
        alert("Fitur berbagi hanya tersedia di HP. Gambar akan diunduh sebagai gantinya.");
        downloadAsImage();
    }
};

const formatDate = (dateString) => {
    if (!dateString) return "";
    const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    };
    return new Date(dateString).toLocaleDateString("id-ID", options);
};

onMounted(() => {
    const menfessId = route.params.id;
    menfessStore.fetchMenfessDetail(menfessId);
});
</script>

