import { defineStore } from "pinia";
import { ref, computed } from "vue";
import api from "@/axios"; // Instance Axios kustom

export const useAuthStore = defineStore("auth", () => {
    // --- STATE ---
    const user = ref(null);
    const token = ref(localStorage.getItem("authToken") || null);
    const errors = ref({});
    const kelompok = ref(null);
    const isLoading = ref(false);
    const successMessage = ref("");

    const clearErrors = () => {
        errors.value = {};
    };
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

            const response = await api.get("/me");
            user.value =
                response.data.payload?.user ??
                response.data.user ??
                response.data;
        } catch (error) {
            console.error("Auto login gagal:", error);
            user.value = null;
            token.value = null;
            localStorage.removeItem("authToken");
        }
    };

    // --- UPDATE PROFILE ---
    const updateProfile = async (formData) => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await api.put("/profile", formData);
            user.value = response.data.user; // update state user
            successMessage.value = "Profil berhasil diperbarui";
            return true;
        } catch (error) {
            if (error.response?.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error("Update Profile Error:", error);
                errors.value = { general: ["Gagal memperbarui profil."] };
            }
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    // --- UPDATE PASSWORD ---
    const updatePassword = async (payload) => {
        isLoading.value = true;
        errors.value = {};
        try {
            await api.put("/profile/password", payload);
            successMessage.value = "Password berhasil diubah";
            return true;
        } catch (error) {
            if (error.response?.status === 422) {
                errors.value = error.response.data.errors;
            } else if (error.response?.status === 400) {
                errors.value = { general: [error.response.data.message] };
            } else {
                console.error("Update Password Error:", error);
                errors.value = { general: ["Gagal mengubah password."] };
            }
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const getKelompokStatus = async () => {
        if (!isAuthenticated.value) return;
        isLoading.value = true;
        try {
            const response = await api.get("/kelompok/status");
            kelompok.value = response.data.payload;
        } catch (error) {
            if (error.response && error.response.status === 404) {
                kelompok.value = null; // Pengguna belum punya kelompok
            } else {
                console.error("Gagal mengambil status kelompok:", error);
            }
        } finally {
            isLoading.value = false;
        }
    };

    const generateKelompok = async () => {
        isLoading.value = true;
        errors.value = {};
        try {
            const response = await api.post("/kelompok/generate");
            kelompok.value = response.data.payload; // Update state dengan kelompok baru
            return true;
        } catch (error) {
            console.error("Gagal generate kelompok:", error);
            if (error.response && error.response.data.message) {
                alert(error.response.data.message);
            }
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    return {
        user,
        token,
        kelompok,
        errors,
        isLoading,
        successMessage,
        isAuthenticated,
        register,
        login,
        logout,
        clearErrors,
        tryAutoLogin,
        updateProfile,
        updatePassword,
        getKelompokStatus,
        generateKelompok,
    };
});
