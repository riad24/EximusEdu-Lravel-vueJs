<template>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <LogoComponent/>
                        <!-- /Logo -->

                        <h4 class="mb-2">Verify Reset Link</h4>
                        <p class="mb-4">Enter your email and pin then you can verify our reset link</p>
                        <form @submit.prevent="verifyPin" class="mb-3">
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
                                <label for="pin" class="form-label">Pin</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="pin"
                                    name="pin"
                                    placeholder="Enter your 6 digit pin"
                                    v-model="form.pin"
                                    autofocus
                                />
                                <div class="form-text text-danger" v-if="errors.pin">{{ errors.pin[0] }}</div>
                            </div>

                            <button type="submit" class="btn btn-primary d-grid w-100">Verify Reset Link</button>
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
    name: "VerifyEmailComponent",
    components: {LogoComponent},
    data() {
        return {
            form: {
                email: null,
                pin: null
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
                this.$router.push({ name: 'auth.forgetPassword' });
            }
        },
        verifyPin: function() {
            try {
                this.$store.dispatch('verifyPin', this.form).then((res) => {
                    alertService.success(res.data.message, 'bottom-center');
                    this.$router.push({ name: 'auth.resetPassword' });
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
