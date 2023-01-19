<template>
    <div class="row">
        <div class="col-md-12 col-12 mb-md-0">
            <BreadcrumbComponent/>
        </div>

        <div class="col-md-12 col-12">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import BreadcrumbComponent from "../components/BreadcrumbComponent";

export default {
    name: "FieldsComponent",
    components: {BreadcrumbComponent}
}
</script>

<style scoped>

</style>
