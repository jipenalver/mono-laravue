import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        authUser: null,
        authErrors: [],
        authProcess: false,
    }),
    getters: {
        user: (state) => state.authUser,
        errors: (state) => state.authErrors,
        processing: (state) => state.authProcess,
    },
    actions: {
        async getToken() {
            await axios.get("/sanctum/csrf-cookie");
        },
        async getUser() {
            await this.getToken();
            const response = await axios.get("/api/user", {
                headers: {
                    Authorization: "Bearer " + sessionStorage.getItem("token"),
                },
            });
            this.authUser = response.data;
        },
        async handleLogin(data) {
            this.authErrors = [];
            this.authProcess = true;
            await this.getToken();

            try {
                // When logging in with a valid email address and password, I want to be redirected to the default home page.
                let response = await axios.post("/api/login", {
                    email: data.email,
                    password: data.password,
                });

                sessionStorage.setItem("token", response.data.token);

                this.router.push("/dashboard");
            } catch (e) {
                // When logging in with an invalid email address and/or password, I want to see error message/s below each invalid input.
                if (e.response.status === 422) {
                    this.authErrors = e.response.data.errors;
                }
                if (e.response.status === 404) {
                    this.authErrors = [e.response.status];
                }
            } finally {
                this.authProcess = false;
            }
        },
        async handleRegister(data) {
            this.authErrors = [];
            this.authProcess = true;
            await this.getToken();

            try {
                // When signing up with a valid email address and password with confirmation, I want to login automatically and be redirected to the default home page.
                let response = await axios.post("/api/register", {
                    name: data.name,
                    email: data.email,
                    password: data.password,
                    password_confirmation: data.password_confirmation,
                });

                sessionStorage.setItem("token", response.data.token);

                this.router.push("/dashboard");
            } catch (e) {
                // When signing up with an invalid email address and/or password, I want to see error message/s below each invalid input.
                if (e.response.status === 422) {
                    this.authErrors = e.response.data.errors;
                }
            } finally {
                this.authProcess = false;
            }
        },
        async handleLogout() {
            // When logging out, I want to be redirected to the login page.
            await this.getToken();
            await axios.get("/api/logout", {
                headers: {
                    Authorization: "Bearer " + sessionStorage.getItem("token"),
                },
            });
            sessionStorage.clear();
            this.authUser = null;
            this.router.push("/");
        },
    },
});
