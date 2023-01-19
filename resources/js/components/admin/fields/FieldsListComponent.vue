<template>
    <LoadingComponent :props="loading"/>

    <div class="card">
        <div class="card-header-with-button">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label text-center">
                    <h5 class="card-title mb-0">{{ $t('menu.fields') }}</h5>
                </div>
                <div class="card-header-button pt-3 pt-md-0">
                    <div class="card-button">
                        <TableLimitComponent :method="list" :search="props.search" :page="paginationPage"/>
                        <FilterComponent/>
                        <div class="btn-group">
                            <ExportComponent/>
                            <ul class="dropdown-menu dropdown-menu-end custom-margin">
                                <li>
                                    <button class="dropdown-item d-flex align-items-center" v-print="'#print'"><i
                                        class="bx bx-printer me-2"></i> {{ $t('button.print') }}
                                    </button>
                                </li>
                                <li>
                                    <a @click.prevent="xls()" href="javascript:void(0);"
                                       class="dropdown-item d-flex align-items-center">
                                        <i class="bx bx-file me-2 scaleX-n1-rtl"></i>{{ $t('button.excel') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <StudentsCreateComponent :props="props"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="collapse" id="filter-box">
            <div class="card custom-card-filter">
                <div class="card-body">
                    <form @submit.prevent="search">
                        <div class="row g-2">
                            <div class="col-md-3 mb-2">
                                <label class="form-label" for="searchName">{{ $t("label.title") }}</label>
                                <input type="text" id="searchName" v-model="props.search.title" class="form-control"
                                       :placeholder="$t('placeholder.field_title')"/>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label" for="searchStatus">{{ $t("label.status") }}</label>
                                <vue-select
                                    class="form-control"
                                    id="searchStatus"
                                    v-model="props.search.status"
                                    :options="[
                                        {id: enums.statusEnum.ACTIVE, name: $t('label.active')},
                                        {id: enums.statusEnum.INACTIVE, name: $t('label.inactive')}
                                    ]"
                                    label-by="name"
                                    value-by="id"
                                    :closeOnSelect="true"
                                    :searchable="true"
                                    :clearOnClose="true"
                                    placeholder="--"
                                    search-placeholder="--"
                                />
                            </div>

                        </div>


                        <div class="row g-2">
                            <div class="col-md-6 mt-3 mb-2">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">
                                    {{ $t('button.search') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary" @click="clear">
                                    {{ $t('button.clear') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <hr class="m-0">
        <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="print">
                <thead>
                <tr>
                    <th>{{ $t('label.institute') }}</th>
                    <th>{{ $t('label.title') }}</th>
                    <th>{{ $t('label.type') }}</th>
                    <th>{{ $t('label.field_type') }}</th>
                    <th>{{ $t("label.status") }}</th>
                    <th class="hidden-print"
                        v-if="permissionChecker('fields')">
                        {{ $t("label.action") }}
                    </th>
                </tr>
                </thead>
                <tbody v-if="fields.length > 0">
                <tr v-for="field in fields" :key="field">
                    <td>{{ field.institute_name }}</td>
                    <td>{{ field.title }}</td>
                    <td>{{ field.type }}</td>
                    <td>{{ field.field_type }}</td>
                    <td>
                        <span :class="statusClass(field.status)">
                            {{ enums.statusEnumArray[field.status] }}
                        </span>
                    </td>
                    <td class="hidden-print"
                        v-if="permissionChecker('fields')">
                        <ActionButtonComponent></ActionButtonComponent>
                        <ul class="dropdown-menu dropdown-menu-end custom-margin">
                            <SmOffCanvasEditComponent v-if="permissionChecker('fields')"
                                                      @click="edit(field)"></SmOffCanvasEditComponent>
                            <SmDeleteComponent
                                v-if="permissionChecker('fields')"
                                @click="destroy(field.id)"></SmDeleteComponent>
                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>

            <div v-if="paginationPage.total > 10" class="pagination-box">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <PaginationTextComponent :props="{ page: paginationPage }"></PaginationTextComponent>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <PaginationBox :pagination="pagination" :method="list"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import {statusEnum, askEnum, fieldNameEnum} from "../../../enums";
import PaginationTextComponent from "../components/pagination/PaginationTextComponent";
import appService from "../../../services/appService";
import ActionButtonComponent from "../components/button/dropdownActionButton/ActionButtonComponent";
import SmDeleteComponent from "../components/button/dropdownActionButton/SmDeleteComponent";
import StudentsCreateComponent from "./FieldsCreateComponent";
import SmOffCanvasEditComponent from "../components/button/dropdownActionButton/SmOffCanvasEditComponent";
import SmViewComponent from "../components/button/dropdownActionButton/SmViewComponent";
import alertService from "../../../services/alertService";
import FilterComponent from "../components/button/collapse/FilterComponent";
import ExportComponent from "../components/button/export/ExportComponent";
import LoadingComponent from "../components/LoadingComponent";
import print from 'vue3-print-nb';
import TableLimitComponent from "../components/TableLimitComponent";
import PaginationBox from "../components/pagination/PaginationBox";

export default {
    name: "FieldsListComponent",
    components: {
        TableLimitComponent,
        FilterComponent,
        ExportComponent,
        SmViewComponent,
        StudentsCreateComponent,
        SmOffCanvasEditComponent,
        PaginationTextComponent,
        ActionButtonComponent,
        SmDeleteComponent,
        LoadingComponent,
        PaginationBox
    },
    data() {
        return {
            loading: {
                isActive: false
            },
            enums: {
                statusEnum: statusEnum,
                askEnum: askEnum,
                statusEnumArray: {
                    [statusEnum.ACTIVE]: this.$t("label.active"),
                    [statusEnum.INACTIVE]: this.$t("label.inactive")
                }
            },
            props: {
                search: {
                    paginate: 1,
                    page: 1,
                    per_page: 10,
                    institute_name: "",
                    title: "",
                    type: null,
                    field_type: null,
                    institute_id: null,
                    status: null,
                },
                form: {
                    title: "",
                    institute_name: "",
                    type: null,
                    field_type: fieldNameEnum.INPUT,
                    institute_id: null,
                    status: statusEnum.ACTIVE,
                },
                errors: {}
            }
        }
    },
    computed: {
        fields: function () {
            return this.$store.getters['field/lists'];
        },
        pagination: function () {
            return this.$store.getters['field/pagination'];
        },
        paginationPage: function () {
            return this.$store.getters['field/page'];
        },

    },
    mounted() {
        this.list();
    },
    methods: {
        permissionChecker(e) {
            return appService.permissionChecker(e);
        },
        statusClass: function (status) {
            return appService.statusClass(status);
        },
        search: function () {
            this.list();
        },
        clear: function () {
            this.props.search.paginate = 1;
            this.props.search.page = 1;
            this.props.search.title = "";
            this.props.search.institute_name = "";
            this.props.search.institute_id = null;
            this.props.search.status = null;
            this.list();
        },
        list: function (page = 1) {
            try {
                this.loading.isActive = true;
                this.props.search.page = page;
                this.$store.dispatch('field/lists', this.props.search).then(res => {
                    this.loading.isActive = false;
                }).catch((err) => {
                    this.loading.isActive = false;
                    alertService.error(err.response.data.message);
                });
            } catch (err) {
                this.loading.isActive = false;
                alertService.error(err.response.data.message);
            }
        },
        edit: function (field) {
            this.$store.dispatch('field/edit', field.id).then(res => {
                this.props.errors = {};
                this.props.form = {
                    title: field.title,
                    type: field.type,
                    field_type: field.field_type,
                    institute_id: field.institute_id,
                    status: field.status,
                };
            }).catch((err) => {
                alertService.error(err.response.data.message);
            });
        },
        destroy: function (id) {
            appService.destroyConfirmation().then((res) => {
                try {
                    this.loading.isActive = true;
                    this.$store.dispatch('field/destroy', {search: this.props.search, id: id}).then((res) => {
                        this.loading.isActive = false;
                        alertService.successFlip(null, this.$t('label.field'));
                    }).catch((err) => {
                        this.loading.isActie = false;
                        alertService.error(err.response.data.message);
                    })
                } catch (err) {
                    this.loading.isActive = false;
                    alertService.error(err.response.data.message);
                }
            }).catch((err) => {
                this.loading.isActive = false;
            })
        },
        xls: function () {
            this.loading.isActive = true;
            this.$store.dispatch('field/export', this.props.search).then(res => {
                this.loading.isActive = false;
                const blob = new Blob([res.data], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = this.$t("menu.fields");
                link.click();
                URL.revokeObjectURL(link.href);
            }).catch((err) => {
                this.loading.isActive = false;
                alertService.error(err.response.data.message);
            });
        }
    },
    directives: {
        print
    }
}
</script>

<style scoped>
@media print {
    .hidden-print {
        display: none !important;
    }
}
</style>
