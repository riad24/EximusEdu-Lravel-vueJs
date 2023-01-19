<template>
    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal" >
        <span>
            <i class="bx bx-plus me-sm-2"></i>
            <span class="d-none d-sm-inline-block">{{ props.title }}</span>
        </span>
    </button>
</template>

<script>
    export default {
        name: "SmModalCreateComponent",
        props: ['props'],
    }
</script>
