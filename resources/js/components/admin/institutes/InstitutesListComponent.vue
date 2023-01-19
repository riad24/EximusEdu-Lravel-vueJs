<template>
    <LoadingComponent :props="loading"/>

    <div class="card">
        <div class="card-header-with-button">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label text-center">
                    <h5 class="card-title mb-0">{{ $t('menu.institutes') }}</h5>
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
                        <InstitutesCreateComponent :props="props"/>
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
                                <label class="form-label" for="searchName">{{ $t("label.name") }}</label>
                                <input type="text" id="searchName" v-model="props.search.name" class="form-control"
                                       :placeholder="$t('placeholder.institute_name')"/>
                            </div>
                        </div>

                        <div class="row g-2">
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


                            <div class="col-md-3 mb-2">
                                <label class="form-label" for="searchDescription">{{ $t("label.description") }}</label>
                                <input type="text" id="searchState" v-model="props.search.description"
                                       class="form-control"
                                       :placeholder="$t('placeholder.about_something')"/>
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
                    <th>{{ $t('label.name') }}</th>
                    <th>{{ $t('label.email') }}</th>
                    <th>{{ $t('label.phone') }}</th>
                    <th>{{ $t("label.status") }}</th>
                    <th class="hidden-print"
                        v-if="permissionChecker('institutes')">
                        {{ $t("label.action") }}
                    </th>
                </tr>
                </thead>
                <tbody v-if="institutes.length > 0">
                <tr v-for="institute in institutes" :key="institute">
                    <td>{{ institute.name }}</td>
                    <td>{{ institute.email }}</td>
                    <td>{{ institute.phone }}</td>
                    <td>
                        <span :class="statusClass(institute.status)">
                            {{ enums.statusEnumArray[institute.status] }}
                        </span>
                    </td>
                    <td class="hidden-print"
                        v-if="permissionChecker('institutes')">
                        <ActionButtonComponent></ActionButtonComponent>
                        <ul class="dropdown-menu dropdown-menu-end custom-margin">
                            <SmOffCanvasEditComponent v-if="permissionChecker('institutes')"
                                                      @click="edit(institute)"></SmOffCanvasEditComponent>
                            <SmDeleteComponent
                                v-if="permissionChecker('institutes')"
                                @click="destroy(institute.id)"></SmDeleteComponent>
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

import {statusEnum, askEnum} from "../../../enums";
import PaginationTextComponent from "../components/pagination/PaginationTextComponent";
import appService from "../../../services/appService";
import ActionButtonComponent from "../components/button/dropdownActionButton/ActionButtonComponent";
import SmDeleteComponent from "../components/button/dropdownActionButton/SmDeleteComponent";
import InstitutesCreateComponent from "./InstitutesCreateComponent";
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
    name: "InstitutesListComponent",
    components: {
        TableLimitComponent,
        FilterComponent,
        ExportComponent,
        SmViewComponent,
        InstitutesCreateComponent,
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
                    name: "",
                    email: "",
                    phone: "",
                    status: null,
                    description: ""
                },
                form: {
                    name: "",
                    email: "",
                    phone: "",
                    status: statusEnum.ACTIVE,
                    description: ""
                },
                errors: {}
            }
        }
    },
    computed: {
        institutes: function () {
            return this.$store.getters['institute/lists'];
        },
        pagination: function () {
            return this.$store.getters['institute/pagination'];
        },
        paginationPage: function () {
            return this.$store.getters['institute/page'];
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
            this.props.search.name = "";
            this.props.search.email = "";
            this.props.search.phone = "";
            this.props.search.status = null;
            this.props.search.description = "";
            this.list();
        },
        list: function (page = 1) {
            try {
                this.loading.isActive = true;
                this.props.search.page = page;
                this.$store.dispatch('institute/lists', this.props.search).then(res => {
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
        edit: function (institute) {
            this.$store.dispatch('institute/edit', institute.id).then(res => {
                this.props.errors = {}
                this.props.form = {
                    name: institute.name,
                    email: institute.email,
                    phone: institute.phone,
                    status: institute.status,
                    description: institute.description
                };
            }).catch((err) => {
                alertService.error(err.response.data.message);
            });
        },
        destroy: function (id) {
            appService.destroyConfirmation().then((res) => {
                try {
                    this.loading.isActive = true;
                    this.$store.dispatch('institute/destroy', {search: this.props.search, id: id}).then((res) => {
                        this.loading.isActive = false;
                        alertService.successFlip(null, this.$t('label.institute'));
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
            this.$store.dispatch('institute/export', this.props.search).then(res => {
                this.loading.isActive = false;
                const blob = new Blob([res.data], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = this.$t("menu.institutes");
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
