<template>
    <TopNav />

    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <router-link to="/"
                                             class="logo d-flex align-items-center w-auto">
                                    <img src="/assets/images/logo.png"
                                         alt="">
                                    <span class="d-none d-lg-block">Appetiser Todo</span>
                                </router-link>
                            </div>

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                        <p class="text-center small">Enter your personal details to create account</p>
                                    </div>

                                    <form class="row g-3"
                                          @submit.prevent="authStore.handleRegister(registerCredential)"
                                          novalidate>
                                        <div class="col-12">
                                            <label for="yourName"
                                                   class="form-label">Your Name</label>
                                            <input type="text"
                                                   v-model="registerCredential.name"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': authStore.errors.name }"
                                                   id="yourName"
                                                   required>
                                            <div v-if="authStore.errors.name"
                                                 class="invalid-feedback">
                                                {{ authStore.errors.name[0] }}
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourEmail"
                                                   class="form-label">Your Email</label>
                                            <input type="email"
                                                   v-model="registerCredential.email"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': authStore.errors.email }"
                                                   id="yourEmail"
                                                   required>
                                            <div v-if="authStore.errors.email"
                                                 class="invalid-feedback">
                                                {{ authStore.errors.email[0] }}
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword"
                                                   class="form-label">Password</label>
                                            <input type="password"
                                                   v-model="registerCredential.password"
                                                   class="form-control"
                                                   :class="{ 'is-invalid': authStore.errors.password }"
                                                   id="yourPassword"
                                                   required>
                                            <div v-if="authStore.errors.password"
                                                 class="invalid-feedback">
                                                {{ authStore.errors.password[0] }}
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourConfirmPassword"
                                                   class="form-label">Confirm Password</label>
                                            <input type="password"
                                                   v-model="registerCredential.password_confirmation"
                                                   class="form-control"
                                                   id="yourConfirmPassword"
                                                   required>
                                        </div>

                                        <div class="col-12">
                                            <button v-if="!authStore.processing"
                                                    class="btn btn-primary w-100"
                                                    type="submit">
                                                Create Account
                                            </button>
                                            <button v-else
                                                    class="btn btn-primary w-100"
                                                    type="submit"
                                                    disabled>
                                                <span class="spinner-border spinner-border-sm"
                                                      role="status"
                                                      aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Already have an account? <router-link to="/login">Log
                                                    in</router-link></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>
</template>

<script setup>

import TopNav from './Includes/TopNav.vue'

import { ref } from 'vue'
import { useAuthStore } from '../../stores/auth'

const authStore = useAuthStore()

const registerCredential = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

</script>