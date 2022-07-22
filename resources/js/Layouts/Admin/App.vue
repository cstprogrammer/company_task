<template>
    <div class="wrapper">
        <Navbar v-bind="auth" />
        <Sidebar v-bind="auth" />

        <slot />

        <Footer />
    </div>
    <!-- ./wrapper -->
</template>

<script>
    //import Link dari inertia
    import { Link } from '@inertiajs/inertia-vue3'
    import Navbar from './Navbar.vue'
    import Sidebar from './Sidebar.vue'
    import Footer from './Footer.vue'

    export default {

        components: {
            Link,
            Navbar,
            Sidebar,
            Footer
        },

        props: {
            auth: Object
        }

    }
</script>
