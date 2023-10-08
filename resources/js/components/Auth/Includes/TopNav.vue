<template>
    <!-- ======= Header ======= -->
    <header id="header"
            class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <router-link to="/"
                         class="logo d-flex align-items-center">
                <img src="assets/images/logo.png"
                     alt="Logo">
                <span class="d-none d-lg-block">Appetiser Todo</span>
            </router-link>
        </div>
        <!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item">
                    <router-link to="/login"
                                 class="nav-link nav-icon">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span class="d-none d-lg-inline-block mx-1">Login</span>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link to="/register"
                                 class="nav-link nav-icon">
                        <i class="bi bi-file-person"></i>
                        <span class="d-none d-lg-inline-block mx-1">Register</span>
                    </router-link>
                </li>

            </ul>
        </nav>
        <!-- End Icons Navigation -->

    </header>
</template>

<script setup>

</script>
