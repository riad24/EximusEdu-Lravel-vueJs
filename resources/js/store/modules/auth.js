import axios from 'axios'


export const auth = {
    state: {
        authStatus: false,
        authToken: null,
        authInfo: {},
        authMenu: {},
        resetInfo: {
            email: null
        },
        authPermission: {},
    },
    getters: {
        authStatus: function (state) {
            return state.authStatus;
        },
        authToken: function (state) {
            return state.authToken;
        },
        authInfo: function (state) {
            return state.authInfo;
        },
        authMenu: function (state) {
            return state.authMenu;
        },
        authPermission: function (state) {
            return state.authPermission;
        },
        resetInfo: function (state) {
            return state.resetInfo;
        }
    },
    actions: {
        login: function (context, payload) {
            return new Promise((resolve, reject) => {
                axios.post('auth/login', payload).then((res) => {
                    context.commit('authLogin', res.data);
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        logout: function (context) {
            return new Promise((resolve, reject) => {
                axios.post('auth/logout').then((res) => {
                    context.commit('authLogout');
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        forgetPassword: function (context, payload) {
            return new Promise((resolve, reject) => {
                axios.post('auth/forgot-password', payload).then((res) => {
                    context.commit('forgetPassword', payload);
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        verifyPin: function (context, payload) {
            return new Promise((resolve, reject) => {
                axios.post('auth/verify/pin', payload).then((res) => {
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
        resetPassword: function (context, payload) {
            return new Promise((resolve, reject) => {
                axios.post('auth/reset-password', payload).then((res) => {
                    context.commit('authLogin', res.data.token);
                    resolve(res);
                }).catch((err) => {
                    reject(err);
                });
            });
        },
    },
    mutations: {
        authLogin: function (state, payload) {
            state.authStatus = true;
            state.authToken = payload.token;
            state.authInfo = payload.user;
            state.authMenu = payload.menu;
            console.log(payload.menu);
            state.authPermission = payload.permission;
        },
        authLogout: function (state) {
            state.authStatus = false;
            state.authToken = null;
            state.authInfo = {};
            state.authMenu = {};
            state.authPermission = {};
        },
        forgetPassword: function (state, payload) {
            state.resetInfo = {
                email: payload.email
            }
        },
        resetPassword: function (state) {
            state.resetInfo = {
                email: null
            }
        }
    },
};
