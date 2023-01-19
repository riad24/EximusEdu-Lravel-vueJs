import {createRouter, createWebHashHistory} from "vue-router";

import store from "../store";

import LoginComponent from "../components/login/LoginComponent";
import ForgetPasswordComponent from "../components/login/ForgetPasswordComponent";
import VerifyEmailComponent from "../components/login/VerifyEmailComponent";
import ResetPasswordComponent from "../components/login/ResetPasswordComponent";
import DashboardComponent from "../components/admin/dashboard/DashboardComponent";
import NotFoundComponent from "../components/NotFoundComponent";
import ExceptionComponent from "../components/ExceptionComponent";
import appService from "../services/appService";
import AdminComponent from "../components/admin/AdminComponent";
import InstitutesComponent from "../components/admin/institutes/InstitutesComponent";
import InstitutesListComponent from "../components/admin/institutes/InstitutesListComponent";
import StudentsComponent from "../components/admin/students/StudentsComponent";
import StudentsListComponent from "../components/admin/students/StudentsListComponent";

const routes = [
    {
        path: '/',
        redirect: {name: 'auth.login'},
        name: 'root'
    },
    {
        path: '/login',
        component: LoginComponent,
        name: 'auth.login',
        meta: {
            guest: true
        }
    },
    {
        path: '/forget-password',
        component: ForgetPasswordComponent,
        name: 'auth.forgetPassword',
        meta: {
            guest: true
        }
    },
    {
        path: '/verify/email',
        name: 'auth.verifyEmail',
        component: VerifyEmailComponent,
        meta: {
            guest: true
        }
    },
    {
        path: '/reset-password',
        name: 'auth.resetPassword',
        component: ResetPasswordComponent,
        meta: {
            guest: true
        }
    },
    {
        path: '/admin',
        component: AdminComponent,
        name: 'admin',
        meta: {
            auth: true,
            permissionUrl: 'dashboard'
        }
    },
    {
        path: '/admin/dashboard',
        component: DashboardComponent,
        name: 'admin.dashboard',
        meta: {
            auth: true,
            permissionUrl: 'dashboard'
        }
    },
    {
        path: '/admin/institutes',
        component: InstitutesComponent,
        name: 'admin.institutes',
        redirect: {name: 'admin.institutes.list'},
        meta: {
            auth: true,
            permissionUrl: 'institutes',
            breadcrumb: 'Institutes'
        },
        children: [
            {
                path: 'list',
                component: InstitutesListComponent,
                name: 'admin.institutes.list',
                meta: {
                    auth: true,
                    permissionUrl: 'institutes',
                    breadcrumb: ''
                }
            },
        ]
    },

    {
        path: '/admin/students',
        component: StudentsComponent,
        name: 'admin.students',
        redirect: {name: 'admin.students.list'},
        meta: {
            auth: true,
            permissionUrl: 'students',
            breadcrumb: 'Institutes'
        },
        children: [
            {
                path: 'list',
                component: StudentsListComponent,
                name: 'admin.students.list',
                meta: {
                    auth: true,
                    permissionUrl: 'students',
                    breadcrumb: ''
                }
            },
        ]
    },



    {
        path: '/:pathMatch(.*)*',
        name: 'route.notFound',
        component: NotFoundComponent
    },
    {
        path: '/exception',
        name: 'route.exception',
        component: ExceptionComponent
    }
];


const permission = store.getters.authPermission;
appService.recursiveRouter(routes, permission);

const router = createRouter({
    linkActiveClass: "active",
    history: createWebHashHistory(process.env.BASE_URL),
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (!store.getters.authStatus) {
            next({
                name: 'auth.login'
            })
        } else {
            if (to.meta.access === false) {
                next({
                    name: 'route.exception'
                })
            } else {
                next()
            }
        }
    } else if (to.matched.some(record => record.meta.guest)) {
        if (store.getters.authStatus) {
            next({
                name: 'admin'
            })
        } else {
            next()
        }
    } else {
        next()
    }
});

export default router
