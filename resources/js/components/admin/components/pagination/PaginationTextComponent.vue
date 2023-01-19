<template>

    <p v-if="props.page.total > 10" class="pagination-text">{{
            $t("message.pagination_label", {
                from: props.page.from, to: props.page.to,
                total: props.page.total
            })
        }}
    </p>
</template>

<script>
export default {
    name: "PaginationTextComponent",
    props: ['props'],
}
</script>

<style scoped>

</style>
