<template>
    <button
        type="button"
        class="btn btn-outline-primary responsive dropdown-toggle me-2"
        data-bs-toggle="dropdown"
        aria-expanded="false"
    >
        <i class="bx bx-export me-sm-2"></i>
        <span class="d-none d-sm-inline-block">{{ $t('button.export') }}</span>
    </button>
</template>

<script>
export default {
    name: "ExportComponent"
}
</script>
