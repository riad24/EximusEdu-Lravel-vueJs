<template>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <LogoComponent/>
                        <!-- /Logo -->

                        <h4 class="mb-2">Reset Password 🔒</h4>
                        <p class="mb-4">Enter your email and new password then you can login by this credentials</p>
                        <form @submit.prevent="resetPassword" class="mb-3">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Enter your email"
                                    v-model="form.email"
                                    autofocus
                                />
                                <div class="form-text text-danger" v-if="errors.email">{{ errors.email[0] }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Enter your new password"
                                    v-model="form.password"
                                    autofocus
                                />
                                <div class="form-text text-danger" v-if="errors.password">{{ errors.password[0] }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Enter your confirm password"
                                    v-model="form.password_confirmation"
                                    autofocus
                                />
                                <div class="form-text text-danger" v-if="errors.password_confirmation">
                                    {{ errors.password_confirmation[0] }}
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary d-grid w-100">Reset Password</button>
                        </form>
                        <div class="text-center">
                            <router-link :to="{ name: 'auth.login' }">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i> Back to login
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LogoComponent from "./LogoComponent";
import alertService from "../../services/alertService";

export default {
    name: "ResetPasswordComponent",
    components: {LogoComponent},
    data() {
        return {
            form: {
                email: null,
                password: null,
                password_confirmation: null
            },
            errors: {}
        }
    },
    mounted() {
        this.emailChecking();
    },
    methods: {
        emailChecking: function () {
            if (this.$store.getters.resetInfo.email) {
                this.form.email = this.$store.getters.resetInfo.email;
            } else {
                this.$router.push({ name: 'auth.verifyEmail' });
            }
        },
        resetPassword: function () {
            try {
                this.$store.dispatch('resetPassword', this.form).then((res) => {
                    alertService.success(res.data.message);
                    this.$router.push({ name: 'admin' });
                }).catch((err) => {
                    this.errors = err.response.data.errors;
                })
            } catch(err) {
                alertService.error(err.response.data.message);
            }
        }
    }
}
</script>

<style scoped>
@import '../../../../public/themes/default/css/pages/page-auth.css';
</style>
