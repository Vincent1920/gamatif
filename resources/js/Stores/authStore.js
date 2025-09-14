import { defineStore } from "pinia";
import { ref, computed } from "vue";
import api from "@/axios"; // Instance Axios kustom

export const useAuthStore = defineStore("auth", () => {
    // --- STATE ---
    const user = ref(null);
    const token = ref(localStorage.getItem("authToken") || null);
    const errors = ref({});
    const isLoading = ref(false);
    const successMessage = ref("");

    // --- GETTERS ---
    const isAuthenticated = computed(() => !!token.value && !!user.value);

    // --- REGISTER ---
    const register = async (formData) => {
        isLoading.value = true;
        errors.value = {};
        successMessage.value = "";

        try {
            const response = await api.post("/register", formData);
            successMessage.value = response.data.message;
            return true;
        } catch (error) {
            if (error.response?.status === 422) {
                errors.value = error.response.data.payload;
            } else {
                console.error("Registration Error:", error);
                errors.value = { general: ["Terjadi kesalahan pada server."] };
            }
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    // --- LOGIN ---
    const login = async (credentials) => {
        isLoading.value = true;
        errors.value = {};

        try {
            const response = await api.post("/login", credentials);
            const responseToken = response.data.payload.token;
            const responseUser = response.data.payload.user;

            token.value = responseToken;
            user.value = responseUser;

            localStorage.setItem("authToken", responseToken);
            api.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${responseToken}`;

            return true;
        } catch (error) {
            if ([401, 403].includes(error.response?.status)) {
                errors.value = { general: [error.response.data.message] };
            } else {
                console.error("Login Error:", error);
                errors.value = { general: ["Terjadi kesalahan pada server."] };
            }
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    // --- LOGOUT ---
    const logout = () => {
        user.value = null;
        token.value = null;
        localStorage.removeItem("authToken");
        delete api.defaults.headers.common["Authorization"];
    };

    // --- AUTO LOGIN ---
    const tryAutoLogin = async () => {
        const savedToken = localStorage.getItem("authToken");
        if (!savedToken) return;

        try {
            token.value = savedToken;
            api.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${savedToken}`;

            // Pastikan endpoint ini ada di backend-mu
            const response = await api.get("/me");
            user.value =
                response.data.payload.user ??
                response.data.user ??
                response.data;
        } catch (error) {
            console.error("Auto login gagal:", error);
            user.value = null;
            token.value = null;
            localStorage.removeItem("authToken");
        }
    };

    return {
        user,
        token,
        errors,
        isLoading,
        successMessage,
        isAuthenticated,
        register,
        login,
        logout,
        tryAutoLogin, // <--- jangan lupa diexport
    };
});
