<template>
    <nav
        class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600"
    >
        <div
            class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4"
        >
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img
                    src="../../../public/images/logo-gamatif.png"
                    class="h-10"
                    alt="Flowbite Logo"
                />
            </a>
            <div
                class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse"
            >
                <button
                    type="button"
                    class="text-white bg-yellow-600 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800"
                >
                    Login
                </button>
                <button
                    data-collapse-toggle="navbar-sticky"
                    type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-sticky"
                    aria-expanded="false"
                >
                    <span class="sr-only">Open main menu</span>
                    <svg
                        class="w-5 h-5"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 17 14"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15"
                        />
                    </svg>
                </button>
            </div>
            <div
                class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1"
                id="navbar-sticky"
            >
                <ul class="flex flex-col md:flex-row md:space-x-8">
                    <li>
                        <a
                            href="#beranda"
                            @click.prevent="scrollTo('beranda')"
                            :class="
                                activeSection === 'beranda'
                                    ? 'text-yellow-700'
                                    : 'text-gray-900 hover:text-yellow-700 dark:text-white'
                            "
                            class="block py-2 px-3"
                        >
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a
                            href="#tentang"
                            @click.prevent="scrollTo('tentang')"
                            :class="
                                activeSection === 'tentang'
                                    ? 'text-yellow-700'
                                    : 'text-gray-900 hover:text-yellow-700 dark:text-white'
                            "
                            class="block py-2 px-3"
                        >
                            Tentang
                        </a>
                    </li>
                    <li>
                        <a
                            href="#kontak"
                            @click.prevent="scrollTo('kontak')"
                            :class="
                                activeSection === 'kontak'
                                    ? 'text-yellow-700'
                                    : 'text-gray-900 hover:text-yellow-700 dark:text-white'
                            "
                            class="block py-2 px-3"
                        >
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script setup>
import { onMounted, onBeforeUnmount, ref } from "vue";

const activeSection = ref("beranda");

function scrollTo(id) {
    const el = document.getElementById(id);
    if (el) {
        el.scrollIntoView({ behavior: "smooth" });
    }
}

// Fungsi untuk update menu aktif saat scroll
function onScroll() {
    const sections = ["beranda", "tentang", "kontak"];
    let current = "tentang";

    for (const id of sections) {
        const el = document.getElementById(id);
        if (el) {
            const rect = el.getBoundingClientRect();
            if (rect.top <= 100 && rect.bottom >= 100) {
                current = id;
                break;
            }
        }
    }
    activeSection.value = current;
}

onMounted(() => {
    window.addEventListener("scroll", onScroll);
});

onBeforeUnmount(() => {
    window.removeEventListener("scroll", onScroll);
});
</script>
