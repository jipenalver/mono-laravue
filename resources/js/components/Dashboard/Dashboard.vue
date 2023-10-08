<template>
    <TopNav />
    <SideNav />

    <main id="main"
          class="main">

        <div class="pagetitle">
            <h1>Welcome to Appetiser Todo!</h1>
            <br>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                </div>
            </div>
        </section>

    </main>
    <!-- End #main -->

    <FooterNav />
</template>

<script setup>

import TopNav from './Includes/TopNav.vue'
import SideNav from './Includes/SideNav.vue'
import FooterNav from './Includes/FooterNav.vue'

</script>