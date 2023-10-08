<template>
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar"
           class="sidebar">

        <ul class="sidebar-nav"
            id="sidebar-nav">

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <router-link to="/dashboard"
                             class="nav-link ">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </router-link>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed"
                   data-bs-target="#components-nav"
                   data-bs-toggle="collapse"
                   href="#">
                    <i class="bi-journal-text"></i><span>Tasks</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav"
                    class="nav-content collapsed"
                    data-bs-parent="#sidebar-nav">
                    <li>
                        <router-link to="/tasks"
                                     active-class="active">
                            <i class="bi bi-circle"></i><span>List of Tasks</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/completed"
                                     active-class="active">
                            <i class="bi bi-circle"></i><span>Completed Tasks</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/archives"
                                     active-class="active">
                            <i class="bi bi-circle"></i><span>Archived Tasks</span>
                        </router-link>
                    </li>
                </ul>
            </li>
            <!-- End Components Nav -->

        </ul>

    </aside>
</template>

<script setup></script>