<template>
    <!-- ======= Header ======= -->
    <header id="header"
            class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <router-link to="/"
                         class="logo d-flex align-items-center">
                <img src="assets/images/logo.png"
                     alt="">
                <span class="d-none d-lg-block">Appetiser Todo</span>
            </router-link>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0"
                       href="#"
                       data-bs-toggle="dropdown">
                        <img src="assets/images/ic_profile.png"
                             alt="Profile"
                             class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            <span v-if="authStore.user">{{ authStore.user.name }}</span>
                        </span>
                    </a>
                    <!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>
                                <span v-if="authStore.user">{{ authStore.user.name }}</span>
                            </h6>
                            <span>User</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <button @click="authStore.handleLogout"
                                    class="dropdown-item d-flex align-items-center">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </button>
                        </li>

                    </ul>
                    <!-- End Profile Dropdown Items -->
                </li>
                <!-- End Profile Nav -->

            </ul>
        </nav>
        <!-- End Icons Navigation -->

    </header>
</template>

<script setup>

import { onMounted } from 'vue'
import { useAuthStore } from "../../../stores/auth"

const authStore = useAuthStore()

onMounted(async () => {
    await authStore.getUser()
})

</script>
