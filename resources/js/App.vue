<template>
    <div class="">
        <Navbar />

        <main class="max-w-screen-xl mx-auto p-4 pt-15 min-h-screen">
            <router-view />
        </main>
        <ContactSection />
    </div>
</template>

<script setup>
import Navbar from "./Components/Navbar.vue";
import ContactSection from "../js/Components/ContactSection.vue";
</script>
