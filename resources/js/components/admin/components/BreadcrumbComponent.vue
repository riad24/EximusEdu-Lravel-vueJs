<template>
    <h4 class="fw-bold py-3 mb-4">
        <span v-for="(val, key) of breadcrumbs" :key="val.path">
            <span class="text-muted fw-light" v-if="key !== Object.keys(breadcrumbs).length - 1">
                <router-link :to="val.path">
                    {{ val.meta.breadcrumb }}
                </router-link> /
            </span>

            <span v-else>
                {{ val.meta.breadcrumb }}
            </span>
        </span>
    </h4>
</template>

<script>
export default {
    name: "BreadcrumbComponent",
    data() {
        return {
            breadcrumbs: []
        }
    },
    watch: {
        $route() {
            this.route();
        }
    },
    created() {
        this.route();
    },
    methods: {
        route: function () {
            let i, routeArray = [], filterBreadCrumbs = this.$route.matched;
            if (filterBreadCrumbs.length > 0) {
                for (i = 0; i < filterBreadCrumbs.length; i++) {
                    if (filterBreadCrumbs[i].meta.breadcrumb) {
                        routeArray[i] = filterBreadCrumbs[i];
                    }
                }
            }
            this.breadcrumbs = routeArray;
        }
    }
}
</script>

<style scoped>

</style>
