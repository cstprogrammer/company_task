<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link">
            <img
                :src="appLogo"
                alt="App Logo"
                class="brand-image img-circle elevation-3"
                style="opacity: 0.8"
            />
            <span class="brand-text font-weight-light">CMS</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img
                        :src="usrImage"
                        class="img-circle elevation-2"
                        alt="User Image"
                    />
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ user.name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul
                    class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >

                    <li class="nav-item">
                        <Link :href="route('users.index')" class="nav-link" :class="{'active' : $page.url.startsWith('/admin/users')}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>User</p>
                        </Link>
                    </li>

                    <li class="nav-item">
                        <Link :href="route('companies.index')"
                              class="nav-link" :class="{'active' : $page.url.startsWith('/admin/companies')}"
                        >
                            <i class="nav-icon fas fa-home"></i>
                            <p>Company</p>
                        </Link>
                    </li>

                    <li class="nav-item">
                        <Link :href="route('departments.index')" class="nav-link" :class="{'active' : $page.url.startsWith('/admin/departments')}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Department</p>
                        </Link>
                    </li>

                    <li class="nav-item">
                        <Link :href="route('employees.index')" class="nav-link" :class="{'active' : $page.url.startsWith('/admin/employees')}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Employee</p>
                        </Link>
                    </li>

                    <li class="nav-header"></li>
                    <li class="nav-item">
                        <Link
                            href="#"
                            class="nav-link bg-danger"
                            @click.prevent="logout"
                        >
                            <i class="fas fa-sign-out-alt nav-icon"></i>
                            <p>LOGOUT</p>
                        </Link>
                    </li>
                    <li class="nav-header"></li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
//import Link dari inertia
import { Link } from "@inertiajs/inertia-vue3";
import appLogo from '../../assets/images/logo.jpg';
import usrImage from '../../assets/images/user.jpg';

export default {
    components: {
        Link,
    },

    data () {
        return {
            appLogo,
            usrImage
        }
    },

    methods: {
        logout (){
            this.$inertia.post("/logout");
        },
    },

    props: {
        user: Object,
    },
};
</script>
