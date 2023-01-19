<template>
    <pagination align="right" :show-disabled="true" :limit="2" :data="pagination"
                @pagination-change-page="page">
        <template #prev-nav>
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">{{ $t('label.previous') }}</span>
        </template>
        <template #next-nav>
            <span class="sr-only">{{ $t('label.next') }}</span>
            <span aria-hidden="true">&raquo;</span>
        </template>
    </pagination>
</template>

<script>

import pagination from "laravel-vue-pagination";

export default {
    name: "PaginationBox",
    components: {pagination},
    props: {
        pagination: {type: Object},
        method: {type: Function}
    },
    methods: {
        page: function (page = 1) {
            this.method(page);
        }
    }
}
</script>

<style scoped>

</style>
