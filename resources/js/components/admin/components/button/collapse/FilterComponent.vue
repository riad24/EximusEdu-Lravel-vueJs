<template>
    <button class="btn btn-outline-primary responsive me-2"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#filter-box"
            aria-expanded="false" aria-controls="filter-box"
    >
        <span>
            <i class="bx bx-filter me-sm-2"></i>
            <span class="d-none d-sm-inline-block">{{ $t('button.filter') }}</span>
        </span>
    </button>
</template>

<script>
export default {
    name: "FilterComponent"
}
</script>
