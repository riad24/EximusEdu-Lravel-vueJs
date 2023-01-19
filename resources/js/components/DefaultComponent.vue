<template>
    <div>
        <div v-if="logged">
            <div class="layout-wrapper layout-content-navbar">
                <div class="layout-container">
                    <MenuComponent/>
                    <div class="layout-page">
                        <NavbarComponent/>
                        <div class="content-wrapper">
                            <div class="container-xxl flex-grow-1 container-p-y">
                                <router-view></router-view>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="!logged">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
import MenuComponent from "./admin/components/MenuComponent";
import NavbarComponent from "./admin/components/NavbarComponent";

export default {
    name: "DefaultComponent",
    components: {MenuComponent, NavbarComponent},

    computed: {
        logged: function () {
            return this.$store.getters.authStatus;
        }
    },
}
</script>
