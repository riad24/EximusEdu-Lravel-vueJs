<template>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <LogoComponent/>
                        <!-- /Logo -->

                        <h4 class="mb-2">Welcome to Sneat! 👋</h4>
                        <p class="mb-4">Please sign-in to your account and start the adventure</p>

                        <form @submit.prevent="login" class="mb-3">
                            <div v-if="errors.validation" class="alert alert-danger alert-dismissible" role="alert">
                                {{ errors.validation }}
                                <button type="button" :click="close" class="btn-close" aria-label="Close"></button>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input
                                    v-model="form.email"
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    name="email-username"
                                    placeholder="Enter your email or username"
                                    autofocus
                                />
                                <div class="form-text text-danger" v-if="errors.email">{{ errors.email[0] }}</div>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <router-link :to="{ name: 'auth.forgetPassword' }"><small>Forgot Password?</small>
                                    </router-link>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input
                                        v-model="form.password"
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        name="password"
                                        placeholder="******"
                                        aria-describedby="password"
                                    />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <div class="form-text text-danger" v-if="errors.password">{{ errors.password[0] }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me"/>
                                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import LogoComponent from "./LogoComponent"
import alertService from "../../services/alertService";

export default {
    name: "LoginComponent",
    components: {LogoComponent},
    data() {
        return {
            form: {
                email: "",
                password: ""
            },
            errors: {},
            permissions: {},
            firstMenu: null
        }
    },
    methods: {
        login: function () {
            try {
                this.$store.dispatch('login', this.form).then((res) => {
                    window.location.reload();
                }).catch((err) => {
                    this.errors = err.response.data.errors;
                })
            } catch (err) {
                alertService.error(err.response.data.message);
            }
        },
        close: function () {
            this.errors = {}
        }
    },
}
</script>


<style scoped>
@import '../../../../public/themes/default/css/pages/page-auth.css';
</style>
