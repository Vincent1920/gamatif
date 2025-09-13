import "flowbite";
import "../css/app.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import router from './Router/index'; // <-- 1. Impor router yang sudah kita buat
import App from "./App.vue";

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router); // <-- 2. Gunakan router di aplikasi Anda

app.mount("#app"); // <-- 3. TAMPILKAN APLIKASI KE HALAMAN! (Sangat Penting)