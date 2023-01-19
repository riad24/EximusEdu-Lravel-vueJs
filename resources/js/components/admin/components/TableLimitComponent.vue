<template>
    <select v-if="page.total > 10" @change="limitChange" v-model="search.per_page" class="btn btn-outline-primary responsive custom-select me-2">
        <option value="10">{{ $t('number.10') }}</option>
        <option value="25">{{ $t('number.25') }}</option>
        <option value="50">{{ $t('number.50') }}</option>
        <option value="100">{{ $t('number.100') }}</option>
        <option value="500">{{ $t('number.500') }}</option>
        <option value="1000">{{ $t('number.1000') }}</option>
    </select>
</template>

<script>

export default {
    name: "TableLimitComponent",
    props: {
        page: { type: Object },
        search: { type: Object },
        method: { type: Function }
    },
    methods: {
        limitChange: function() {
            this.method();
        }
    }
}
</script>
