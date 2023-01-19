<template>
    <LoadingComponent :props="loading"/>

    <div class="card">
        <div class="card-header-with-button">
            <div class="card-header flex-column flex-md-row">
                <div class="head-label text-center">
                    <h5 class="card-title mb-0">{{ $t('menu.students') }}</h5>
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
                                <label class="form-label" for="searchName">{{ $t("label.class_name") }}</label>
                                <input type="text" id="searchClassName" v-model="props.search.class_name" class="form-control"
                                       :placeholder="$t('placeholder.student_class_name')"/>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-3 mb-2">
                                <label class="form-label" for="searchName">{{ $t("label.name") }}</label>
                                <input type="text" id="searchName" v-model="props.search.name" class="form-control"
                                       :placeholder="$t('placeholder.student_name')"/>
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
                    <th>{{ $t('label.institute') }}</th>
                    <th>{{ $t('label.class_name') }}</th>
                    <th>{{ $t('label.name') }}</th>
                    <th>{{ $t('label.email') }}</th>
                    <th>{{ $t('label.phone') }}</th>
                    <th>{{ $t("label.status") }}</th>
                    <th class="hidden-print"
                        v-if="permissionChecker('students')">
                        {{ $t("label.action") }}
                    </th>
                </tr>
                </thead>
                <tbody v-if="students.length > 0">
                <tr v-for="student in students" :key="student">
                    <td>{{ student.institute_name }}</td>
                    <td>{{ student.class_name }}</td>
                    <td>{{ student.name }}</td>
                    <td>{{ student.email }}</td>
                    <td>{{ student.phone }}</td>
                    <td>
                        <span :class="statusClass(student.status)">
                            {{ enums.statusEnumArray[student.status] }}
                        </span>
                    </td>
                    <td class="hidden-print"
                        v-if="permissionChecker('students')">
                        <ActionButtonComponent></ActionButtonComponent>
                        <ul class="dropdown-menu dropdown-menu-end custom-margin">
                            <SmOffCanvasEditComponent v-if="permissionChecker('students')"
                                                      @click="edit(student)"></SmOffCanvasEditComponent>
                            <SmDeleteComponent
                                v-if="permissionChecker('students')"
                                @click="destroy(student.id)"></SmDeleteComponent>
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
import StudentsCreateComponent from "./StudentsCreateComponent";
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
    name: "StudentsListComponent",
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
                    name: "",
                    institute_name: "",
                    class_name: "",
                    email: "",
                    phone: "",
                    institute_id: null,
                    status: null,
                },
                form: {
                    name: "",
                    class_name: "",
                    institute_name: "",
                    email: "",
                    phone: "",
                    institute_id: null,
                    status: statusEnum.ACTIVE,
                },
                errors: {}
            }
        }
    },
    computed: {
        students: function () {
            return this.$store.getters['student/lists'];
        },
        pagination: function () {
            return this.$store.getters['student/pagination'];
        },
        paginationPage: function () {
            return this.$store.getters['student/page'];
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
            this.props.search.class_name = "";
            this.props.search.institute_name = "";
            this.props.search.institute_id = null;
            this.props.search.email = "";
            this.props.search.phone = "";
            this.props.search.status = null;
            this.list();
        },
        list: function (page = 1) {
            try {
                this.loading.isActive = true;
                this.props.search.page = page;
                this.$store.dispatch('student/lists', this.props.search).then(res => {
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
        edit: function (student) {
            this.$store.dispatch('student/edit', student.id).then(res => {
                this.props.errors = {}
                this.props.form = {
                    name: student.name,
                    class_name: student.class_name,
                    institute_id: student.institute_id,
                    email: student.email,
                    phone: student.phone,
                    status: student.status,
                };
            }).catch((err) => {
                alertService.error(err.response.data.message);
            });
        },
        destroy: function (id) {
            appService.destroyConfirmation().then((res) => {
                try {
                    this.loading.isActive = true;
                    this.$store.dispatch('student/destroy', {search: this.props.search, id: id}).then((res) => {
                        this.loading.isActive = false;
                        alertService.successFlip(null, this.$t('label.student'));
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
            this.$store.dispatch('student/export', this.props.search).then(res => {
                this.loading.isActive = false;
                const blob = new Blob([res.data], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = this.$t("menu.students");
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
