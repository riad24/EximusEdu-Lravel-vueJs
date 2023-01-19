<template>
    <OffCanvasCreateComponent  @click="reset()" :props="addButton"/>
    <LoadingComponent :props="loading"/>

    <div class="offcanvas offcanvas-end width-adjust" tabindex="-1" id="offcanvasBackdrop"
         aria-labelledby="offcanvasBackdropLabel">
        <div class="offcanvas-header border-bottom">
            <h5 id="offcanvasBackdropLabel" class="offcanvas-title">{{ $t("menu.fields") }}</h5>
            <button type="button" @click="reset()" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form @submit.prevent="save" enctype="multipart/form-data">
                <div class="row g-2">
                    <div class="col-md-6 mb-2">
                        <label class="form-label" for="institute_id">{{ $t("label.institute") }} <span
                            class="text-danger">*</span></label>
                        <vue-select
                            class="form-control"
                            id="institute_id"
                            v-bind:class="props.errors.institute_id ? 'is-invalid' : ''"
                            v-model="props.form.institute_id"
                            :options="institutes"
                            label-by="name"
                            value-by="id"
                            :closeOnSelect="true"
                            :searchable="true"
                            :clearOnClose="true"
                            placeholder="--"
                            search-placeholder="--"
                        />
                        <div class="invalid-feedback" v-if="props.errors.institute_id">
                            {{ props.errors.institute_id[0] }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="form-label" for="title">{{ $t("label.title") }} <span
                            class="text-danger">*</span></label>
                        <input type="text" id="title" v-model="props.form.title" class="form-control"
                               v-bind:class="props.errors.title ? 'is-invalid' : ''"
                               :placeholder="$t('placeholder.field_title')"/>
                        <div class="invalid-feedback" v-if="props.errors.title">{{
                                props.errors.title[0]
                            }}
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label" for="type">{{ $t("label.type") }} <span
                            class="text-danger">*</span></label>
                        <vue-select
                            class="form-control"
                            id="type"
                            v-model="props.form.type"
                            :options="[
                                        {id: enums.fieldTypeEnum.TEXT, name: 'Text'},
                                        {id: enums.fieldTypeEnum.NUMBER, name: 'Number'},
                                        {id: enums.fieldTypeEnum.DATE, name: 'Date'},
                                        {id: enums.fieldTypeEnum.RADIO, name: 'Radio'},
                                        {id: enums.fieldTypeEnum.CHECKBOX, name: 'Checkbox'},
                                        {id: enums.fieldTypeEnum.PASSWORD, name: 'Password'},
                                    ]"
                            label-by="name"
                            value-by="id"
                            :closeOnSelect="true"
                            :searchable="true"
                            :clearOnClose="true"
                            placeholder="--"
                            search-placeholder="--"
                        />
                        <div class="invalid-feedback" v-if="props.errors.type">
                            {{ props.errors.type[0] }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label class="form-label" for="field_type">{{ $t("label.field_type") }} <span
                            class="text-danger">*</span></label>
                        <vue-select
                            class="form-control"
                            id="field_type"
                            v-model="props.form.field_type"
                            :options="[
                                        {id: enums.fieldNameEnum.INPUT, name: 'Input'},
                                    ]"
                            label-by="name"
                            value-by="id"
                            :closeOnSelect="true"
                            :searchable="true"
                            :clearOnClose="true"
                            placeholder="--"
                            search-placeholder="--"
                        />

                        <div class="invalid-feedback" v-if="props.errors.field_type">
                            {{ props.errors.field_type[0] }}
                        </div>
                    </div>


                </div>
                <div class="row g-2">
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
import {askEnum, statusEnum,fieldTypeEnum,fieldNameEnum} from "../../../enums";
import appService from "../../../services/appService";
import alertService from "../../../services/alertService";
import OffCanvasCreateComponent from "../components/button/offCanvas/OffCanvasCreateComponent";

export default {
    name: "FieldsCreateComponent",
    components: {LoadingComponent, OffCanvasCreateComponent},
    props: ['props'],
    data() {
        return {
            loading: {
                isActive: false,
            },
            enums: {
                statusEnum: statusEnum,
                fieldTypeEnum: fieldTypeEnum,
                fieldNameEnum: fieldNameEnum,
                askEnum: askEnum
            },
            addButton: {
                title: this.$t("button.add_field")
            },
        }
    },
    computed: {
        institutes: function () {
            return this.$store.getters['institute/lists'];
        },
    },
    mounted() {
        this.$store.dispatch('institute/lists', {status: statusEnum.ACTIVE});
    },
    methods: {
        permissionChecker(e) {
            return appService.permissionChecker(e);
        },

        save: function () {
            const fd = new FormData();
            fd.append('title', this.props.form.title);
            fd.append('type', this.props.form.type);
            fd.append('field_type', this.props.form.field_type);
            fd.append('institute_id', this.props.form.institute_id);
            fd.append('status', this.props.form.status);

            const tempId = this.$store.getters['field/temp'].temp_id;
            this.loading.isActive = true;
            this.$store.dispatch('field/save', {
                form: fd,
                search: this.props.search
            }).then((res) => {
                appService.offCanvas();
                alertService.successFlip((tempId === null ? 0 : 1), this.$t('label.field'));
                this.loading.isActive = false;
                this.props.form = {
                    title: "",
                    type: null,
                    field_type: fieldNameEnum.INPUT,
                    institute_id: null,
                    status: statusEnum.ACTIVE,
                };
                this.props.errors = {};
                this.$refs.imageProperty.value = null;
            }).catch((err) => {
                this.loading.isActive = false;
                this.props.errors = err.response.data.errors;
            });
        },
        reset: function () {
            this.$store.dispatch('field/reset').then().catch();
            this.props.errors = {};
            this.$props.props.form = {
                title: "",
                type: null,
                field_type: fieldNameEnum.INPUT,
                institute_id: null,
                status: statusEnum.ACTIVE,
            };
            this.props.errors = {};
        }
    }
}
</script>

<style scoped>

</style>
