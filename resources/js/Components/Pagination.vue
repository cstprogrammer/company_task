<template>
    <nav aria-label="Page navigation example" v-if="showPagination">
        <ul class="pagination">
            <li
                class="page-item"
                v-for="(link, key) in links"
                :key="key"
                v-bind:class="isActive(link)"
            >
                <Link
                    class="page-link"
                    :href="link.url"
                    v-if="link.url"
                    >{{ link.label }}</Link
                >
                <Link
                    class="page-link"
                    href="#"
                    v-else
                    @click.prevent="handleNoLink"
                    >{{ link.label }}</Link
                >
            </li>
        </ul>
    </nav>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
    components: {
        Link,
    },
    props: {
        links: Array,
    },
    computed: {
        showPagination() {
            return this.links.length > 3;
        },
    },
    methods: {
        isActive(link) {
            return link.active === true ? "active" : "normal";
        },
        handleNoLink() {
            return false;
        },
    },
};
</script>
