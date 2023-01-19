<template>
    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
         id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                    <i class="bx bx-search fs-4 lh-0"></i>
                    <input
                        type="text"
                        class="form-control border-0 shadow-none"
                        placeholder="Search..."
                        aria-label="Search..."
                    />
                </div>
            </div>
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Language -->
                <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="flag-icon flag-icon-usa flag-icon-squared rounded-circle me-1 fs-3"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i class="flag-icon flag-icon-usa flag-icon-squared rounded-circle fs-4 me-1"></i>
                                <span class="align-middle">{{ $t('label.english') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i class="flag-icon flag-icon-bgd flag-icon-squared rounded-circle fs-4 me-1"></i>
                                <span class="align-middle">{{ $t('label.bangla') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="" alt class="w-px-40 h-auto rounded-circle"/>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="" alt class="w-px-40 h-auto rounded-circle"/>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">John Doe</span>
                                        <small class="text-muted">Admin</small>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Change Password</span>
                            </a>
                        </li>

                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" @click.prevent="logout">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    name: "NavbarComponent",
    methods: {
        logout: function() {
            try {
                this.$store.dispatch('logout').then((res) => {
                    window.location.reload();
                }).catch((err) => {
                    console.log(err);
                })
            } catch(e) {
                console.log(e);
            }
        }
    }
}
</script>

<style scoped>

</style>
