<template>
    <div class="p-8 mt-15">
        <!-- Judul -->
        <h1 class="text-3xl font-bold mb-8 text-gray-800">
            Selamat Datang,
            <span class="text-yellow-600">Nama Mahasiswa</span> 🎉
        </h1>

        <!-- Grid Bento -->
        <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
            <!-- Kartu Profil -->
            <div
                class="md:col-span-2 bg-white rounded-2xl shadow-sm hover:shadow-md p-6 flex flex-col items-center justify-center transition"
            >
                <img
                    src="https://ui-avatars.com/api/?name=M+Mahasiswa&background=eab308&color=fff"
                    class="w-20 h-20 rounded-full mb-4"
                />
                <h2 class="text-xl font-semibold text-gray-800">
                    Nama Mahasiswa
                </h2>
                <p class="text-sm text-gray-500">NIM: 12345678</p>
                <p class="text-sm text-gray-500">Kelompok: <span class="text-gray-300">belum mengambil kelompok</span></p>
                <button
                    class="mt-4 bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600"
                >
                    Lihat Profil
                </button>
            </div>

            <!-- Jadwal -->
            <div
                class="md:col-span-4 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition"
            >
                <h2 class="text-lg font-semibold mb-4 text-gray-800">
                    📅 Jadwal Kegiatan
                </h2>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-center justify-between">
                        <span>PKKMB Hari 1</span>
                        <span class="text-gray-500">12 Sept</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>PKKMB Hari 2</span>
                        <span class="text-gray-500">13 Sept</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span>Pengarahan Akademik</span>
                        <span class="text-gray-500">14 Sept</span>
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
                        Harap membawa KTM sementara saat hadir PKKMB
                    </p>
                    <p class="border-l-4 border-yellow-400 pl-3">
                        Follow Instagram @gamatif untuk info terbaru
                    </p>
                </div>
            </div>

            <!-- Statistik -->
            <div
                class="md:col-span-3 bg-white rounded-2xl shadow-sm hover:shadow-md p-6 transition"
            >
                <h2 class="text-lg font-semibold mb-4">
                    📲 Jangan Lupa Follow Yaa!!
                </h2>
                <div class="space-y-3 text-sm text-gray-600">
                    <p class="border-l-4 border-yellow-400 pl-3">
                        Instagram HMIF
                    </p>
                    <p class="border-l-4 border-yellow-400 pl-3">
                        Instagram GAMATIF
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
