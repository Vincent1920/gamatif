<template>
    <div class="min-h-screen bg-gray-100 py-12 px-4">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">
                Form Registrasi Mahasiswa Baru
            </h1>

            <div
                v-if="successMessage"
                class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg"
            >
                {{ successMessage }}
            </div>

            <div
                v-if="errors.general"
                class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded-lg"
            >
                {{ errors.general[0] }}
            </div>

            <form @submit.prevent="handleSubmit" class="space-y-6">
                <div>
                    <label
                        for="nama_lengkap"
                        class="block text-sm font-medium text-gray-700"
                        >Nama Lengkap</label
                    >
                    <input
                        v-model="form.nama_lengkap"
                        type="text"
                        id="nama_lengkap"
                        placeholder="Nama Lengkap Anda"
                        class="mt-1 block w-full rounded-lg border px-4 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        :class="
                            errors.nama_lengkap
                                ? 'border-red-500'
                                : 'border-gray-300'
                        "
                    />
                    <p
                        v-if="errors.nama_lengkap"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ errors.nama_lengkap[0] }}
                    </p>
                </div>

                <div>
                    <label
                        for="nim"
                        class="block text-sm font-medium text-gray-700"
                        >NIM</label
                    >
                    <input
                        v-model="form.nim"
                        type="text"
                        id="nim"
                        placeholder="NIM Anda"
                        class="mt-1 block w-full rounded-lg border px-4 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        :class="
                            errors.nim ? 'border-red-500' : 'border-gray-300'
                        "
                    />
                    <p v-if="errors.nim" class="text-red-500 text-xs mt-1">
                        {{ errors.nim[0] }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700"
                        >Jenis Kelamin</label
                    >
                    <div class="mt-2 flex gap-6">
                        <label class="flex items-center gap-2">
                            <input
                                v-model="form.jenis_kelamin"
                                type="radio"
                                name="jenis_kelamin"
                                value="L"
                                class="text-yellow-500 focus:ring-yellow-400"
                            />
                            <span class="text-gray-700">Laki-laki</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input
                                v-model="form.jenis_kelamin"
                                type="radio"
                                name="jenis_kelamin"
                                value="P"
                                class="text-yellow-500 focus:ring-yellow-400"
                            />
                            <span class="text-gray-700">Perempuan</span>
                        </label>
                    </div>
                    <p
                        v-if="errors.jenis_kelamin"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ errors.jenis_kelamin[0] }}
                    </p>
                </div>

                <div>
                    <label
                        for="tanggal_lahir"
                        class="block text-sm font-medium text-gray-700"
                        >Tanggal Lahir</label
                    >
                    <input
                        v-model="form.tanggal_lahir"
                        type="date"
                        id="tanggal_lahir"
                        class="mt-1 block w-full rounded-lg border px-4 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        :class="
                            errors.tanggal_lahir
                                ? 'border-red-500'
                                : 'border-gray-300'
                        "
                    />
                    <p
                        v-if="errors.tanggal_lahir"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ errors.tanggal_lahir[0] }}
                    </p>
                </div>

                <div>
                    <label
                        for="alamat"
                        class="block text-sm font-medium text-gray-700"
                        >Alamat</label
                    >
                    <textarea
                        v-model="form.alamat"
                        id="alamat"
                        rows="3"
                        placeholder="Jl. Dipatiukur No. 112, Bandung"
                        class="mt-1 block w-full rounded-lg border px-4 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        :class="
                            errors.alamat ? 'border-red-500' : 'border-gray-300'
                        "
                    ></textarea>
                    <p v-if="errors.alamat" class="text-red-500 text-xs mt-1">
                        {{ errors.alamat[0] }}
                    </p>
                </div>

                <div>
                    <label
                        for="nomor_whatsapp"
                        class="block text-sm font-medium text-gray-700"
                        >Nomor WhatsApp</label
                    >
                    <input
                        v-model="form.nomor_whatsapp"
                        type="text"
                        id="nomor_whatsapp"
                        placeholder="081234567890"
                        class="mt-1 block w-full rounded-lg border px-4 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        :class="
                            errors.nomor_whatsapp
                                ? 'border-red-500'
                                : 'border-gray-300'
                        "
                    />
                    <p
                        v-if="errors.nomor_whatsapp"
                        class="text-red-500 text-xs mt-1"
                    >
                        {{ errors.nomor_whatsapp[0] }}
                    </p>
                </div>

                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700"
                        >Email</label
                    >
                    <input
                        v-model="form.email"
                        type="email"
                        id="email"
                        placeholder="email-unikom@mahasiswa.unikom.ac.id"
                        class="mt-1 block w-full rounded-lg border px-4 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        :class="
                            errors.email ? 'border-red-500' : 'border-gray-300'
                        "
                    />
                    <p v-if="errors.email" class="text-red-500 text-xs mt-1">
                        {{ errors.email[0] }}
                    </p>
                </div>

                <!-- Menggunakan CustomFileInput untuk bukti registrasi -->
                <CustomFileInput
                    id="bukti_registrasi"
                    label="Bukti Registrasi"
                    v-model="form.bukti_registrasi"
                    :error="
                        errors.bukti_registrasi
                            ? errors.bukti_registrasi[0]
                            : ''
                    "
                    :multiple="false"
                />

                <!-- CustomFileInput untuk bukti sosmed dengan multiple files -->
                <CustomFileInput
                    id="bukti_sosmed"
                    label="Bukti Follow Sosial Media (Minimal 3 File)"
                    v-model="form.bukti_sosmed"
                    :error="errors.bukti_sosmed ? errors.bukti_sosmed[0] : ''"
                    :multiple="true"
                />

                <div class="pt-4">
                    <button
                        type="submit"
                        :disabled="!isFormValid || isLoading"
                        class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 rounded-lg shadow-md transition disabled:bg-gray-400 disabled:cursor-not-allowed"
                    >
                        {{ isLoading ? "Mengirim..." : "Registrasi" }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <SuccessModal
        :show="showSuccessModal"
        title="Registrasi Berhasil!"
        :description="successMessage"
        @close="showSuccessModal = false"
        to="/login-maba"
    />
</template>

<script setup>
import { ref, computed, nextTick } from "vue";
import { useAuthStore } from "@/Stores/authStore";
import { storeToRefs } from "pinia";
import SuccessModal from "../../Components/SuccessModal.vue";
import CustomFileInput from "../../Components/CustomFileInput.vue";

const authStore = useAuthStore();
const { errors, isLoading, successMessage } = storeToRefs(authStore);

const showSuccessModal = ref(false);

const form = ref({
    nama_lengkap: "",
    nim: "",
    jenis_kelamin: "L",
    tanggal_lahir: "",
    alamat: "",
    nomor_whatsapp: "",
    email: "",
    bukti_registrasi: null,
    bukti_sosmed: [],
});

// 2. Definisikan urutan field di form Anda
const fieldOrder = [
    "nama_lengkap",
    "nim",
    "jenis_kelamin",
    "tanggal_lahir",
    "alamat",
    "nomor_whatsapp",
    "email",
    "bukti_registrasi",
    "bukti_sosmed",
];

// Computed property untuk validasi form
const isFormValid = computed(() => {
    // const emailPattern = /^[a-zA-Z0-9._%+-]+@mahasiswa\.unikom\.ac\.id$/;

    return (
        form.value.nama_lengkap.trim() !== "" &&
        form.value.nim.trim() !== "" &&
        form.value.tanggal_lahir !== "" &&
        form.value.alamat.trim() !== "" &&
        form.value.nomor_whatsapp.trim() !== "" &&
        form.value.email.trim() !== "" &&
        // emailPattern.test(form.value.email.trim()) && 
        form.value.bukti_registrasi !== null &&
        form.value.bukti_sosmed.length >= 3
    );
});

const handleSubmit = async () => {
    const formData = new FormData();

    for (const key in form.value) {
        if (key === "bukti_sosmed") {
            form.value.bukti_sosmed.forEach((file) => {
                formData.append("bukti_sosmed[]", file);
            });
        } else if (form.value[key] !== null) {
            formData.append(key, form.value[key]);
        }
    }

    const isSuccess = await authStore.register(formData);

    if (isSuccess) {
        showSuccessModal.value = true;

        // Reset form
        form.value = {
            nama_lengkap: "",
            nim: "",
            jenis_kelamin: "L",
            tanggal_lahir: "",
            alamat: "",
            nomor_whatsapp: "",
            email: "",
            bukti_registrasi: null,
            bukti_sosmed: [],
        };
    } else {
        // 3. Tambahkan blok 'else' untuk menangani kegagalan

        // Tunggu DOM selesai diperbarui dengan pesan error
        await nextTick();

        // Cari field pertama yang memiliki error berdasarkan urutan
        const firstErrorField = fieldOrder.find((field) => errors.value[field]);

        if (firstErrorField) {
            // Dapatkan elemen HTML dari field yang error
            const errorElement = document.querySelector(`#${firstErrorField}`);

            if (errorElement) {
                // Scroll ke elemen tersebut dengan halus
                errorElement.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
            }
        }
    }
};
</script>
