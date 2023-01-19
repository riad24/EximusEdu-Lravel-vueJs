<template>
    <router-link class="btn btn-sm btn-outline-primary m-1" :to="{ name: this.$props.link, params: {id: this.$props.id } }">
        <i class="bx bxs-show"></i> {{ $t("button.view") }}
    </router-link>
</template>

<script>
export default {
    name: "SmViewComponent",
    props: {
        link: String,
        id: Number
    }
}
</script>

<style scoped>

</style>




