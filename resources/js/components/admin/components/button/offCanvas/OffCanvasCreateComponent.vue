<template>
    <button
        class="btn btn-primary responsive"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasBackdrop"
        aria-controls="offcanvasBackdrop">
        <span>
            <i class="bx bx-plus me-sm-2"></i>
            <span class="d-none d-sm-inline-block">{{ props.title }}</span>
        </span>
    </button>
</template>

<script>
export default {
    name: "OffCanvasCreateComponent",
    props: ['props']
}
</script>
