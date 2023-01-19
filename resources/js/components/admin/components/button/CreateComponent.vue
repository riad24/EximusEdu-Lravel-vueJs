<template>
    <router-link class="btn btn-primary responsive" :to="{ name: this.props.link }">
        <span>
            <i class="bx bx-plus me-sm-2"></i>
            <span class="d-none d-sm-inline-block">{{ props.title }}</span>
        </span>
    </router-link>
</template>

<script>
export default {
    name: "CreateComponent",
    props: ['props']
}
</script>
