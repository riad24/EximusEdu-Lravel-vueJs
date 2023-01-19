<template>
    <OffCanvasCreateComponent  @click="reset()" :props="addButton"/>
    <LoadingComponent :props="loading"/>

    <div class="offcanvas offcanvas-end width-adjust" tabindex="-1" id="offcanvasBackdrop"
         aria-labelledby="offcanvasBackdropLabel">
        <div class="offcanvas-header border-bottom">
            <h5 id="offcanvasBackdropLabel" class="offcanvas-title">{{ $t("menu.institutes") }}</h5>
            <button type="button" @click="reset()" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form @submit.prevent="save" enctype="multipart/form-data">
                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label" for="name">{{ $t("label.name") }} <span
                            class="text-danger">*</span></label>
                        <input type="text" id="name" v-model="props.form.name" class="form-control"
                               v-bind:class="props.errors.name ? 'is-invalid' : ''"
                               :placeholder="$t('placeholder.institute_name')"/>
                        <div class="invalid-feedback" v-if="props.errors.name">{{
                                props.errors.name[0]
                            }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="form-label" for="email">{{ $t("label.email") }} <span
                            class="text-danger">*</span></label>
                        <input type="email" id="email" v-model="props.form.email" class="form-control"
                               v-bind:class="props.errors.email ? 'is-invalid' : ''"
                               :placeholder="$t('placeholder.email')"/>
                        <div class="invalid-feedback" v-if="props.errors.email">{{
                            props.errors.email[0]
                            }}
                        </div>
                    </div>

                </div>
                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label" for="phone">{{ $t("label.phone") }} <span
                            class="text-danger">*</span></label>
                        <input type="text" id="phone" v-on:keypress="phoneNumber($event)"
                               v-model="props.form.phone"
                               class="form-control"
                               v-bind:class="props.errors.phone ? 'is-invalid' : ''"
                               :placeholder="$t('placeholder.phone')"/>
                        <div class="invalid-feedback" v-if="props.errors.phone">{{
                            props.errors.phone[0]
                            }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="active" class="form-label d-block">{{ $t('label.status') }}</label>
                        <div class="form-check form-check-inline mt-2"
                             v-bind:class="props.errors.status ? 'is-invalid' : ''">
                            <input class="form-check-input" v-model="props.form.status" type="radio"
                                   v-bind:class="props.errors.status ? 'is-invalid' : ''"
                                   id="active" :value="enums.statusEnum.ACTIVE">
                            <label class="form-check-label" for="active">{{ $t('label.active') }}</label>
                        </div>
                        <div class="form-check form-check-inline"
                             v-bind:class="props.errors.status ? 'is-invalid' : ''">
                            <input class="form-check-input" v-model="props.form.status" type="radio"
                                   v-bind:class="props.errors.status ? 'is-invalid' : ''"
                                   id="inactive" :value="enums.statusEnum.INACTIVE">
                            <label class="form-check-label" for="inactive">{{ $t('label.inactive') }}</label>
                        </div>
                        <div class="invalid-feedback" v-if="props.errors.status">
                            {{ props.errors.status[0] }}
                        </div>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-12 mb-2">
                        <label class="form-label" for="description">{{ $t("label.description") }}</label>
                        <textarea id="description" v-model="props.form.description" class="form-control" rows="5"
                                  v-bind:class="props.errors.description ? 'is-invalid' : ''"
                                  :placeholder="$t('placeholder.about_something')"></textarea>
                        <div class="invalid-feedback" v-if="props.errors.description">{{
                                props.errors.description[0]
                            }}
                        </div>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-md-6 mb-2 mt-3">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">{{ $t('button.save') }}</button>
                        <button type="button" class="btn btn-outline-secondary" @click="reset()"
                                data-bs-dismiss="offcanvas">{{ $t('button.cancel') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import LoadingComponent from "../components/LoadingComponent";
import {askEnum, statusEnum} from "../../../enums";
import appService from "../../../services/appService";
import alertService from "../../../services/alertService";
import OffCanvasCreateComponent from "../components/button/offCanvas/OffCanvasCreateComponent";

export default {
    name: "InstitutesCreateComponent",
    components: {LoadingComponent, OffCanvasCreateComponent},
    props: ['props'],
    data() {
        return {
            loading: {
                isActive: false,
            },
            enums: {
                statusEnum: statusEnum,
                askEnum: askEnum
            },
            addButton: {
                title: this.$t("button.add_institute")
            },
        }
    },
    computed: {},
    mounted() {},
    methods: {
        permissionChecker(e) {
            return appService.permissionChecker(e);
        },
        phoneNumber(e) {
            return appService.phoneNumber(e);
        },
        save: function () {
            const fd = new FormData();
            fd.append('name', this.props.form.name);
            fd.append('email', this.props.form.email);
            fd.append('phone', this.props.form.phone);
            fd.append('status', this.props.form.status);
            fd.append('description', this.props.form.description);

            const tempId = this.$store.getters['institute/temp'].temp_id;
            this.loading.isActive = true;
            this.$store.dispatch('institute/save', {
                form: fd,
                search: this.props.search
            }).then((res) => {
                appService.offCanvas();
                alertService.successFlip((tempId === null ? 0 : 1), this.$t('label.institute'));
                this.loading.isActive = false;
                this.props.form = {
                    name: "",
                    email: "",
                    phone: "",
                    status: statusEnum.ACTIVE,
                    description: ""
                };
                this.props.errors = {};
                this.$refs.imageProperty.value = null;
            }).catch((err) => {
                this.loading.isActive = false;
                this.props.errors = err.response.data.errors;
            });
        },
        reset: function () {
            this.$store.dispatch('institute/reset').then().catch();
            this.props.errors = {};
            this.$props.props.form = {
                name: "",
                email: "",
                phone: "",
                status: statusEnum.ACTIVE,
                description: ""
            };
            this.props.errors = {};
        }
    }
}
</script>

<style scoped>

</style>
