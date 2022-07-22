<template>
    <div class="wrapper">
        <slot />
    </div>
    <!-- ./wrapper -->
</template>

<script>
    //import Link dari inertia
    import { Link } from '@inertiajs/inertia-vue3'

    export default {

        components: {
            Link,
        },

        props: {
            auth: Object,
            errors: Object
        }

    }
</script>
