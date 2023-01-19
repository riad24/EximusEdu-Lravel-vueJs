import {createStore} from 'vuex';

import {auth} from './modules/auth'
import {institute} from './modules/institute';
import {student} from './modules/student';
import createPersistedState from "vuex-persistedstate";

export default new createStore({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        institute,
        student,
    },
    plugins: [createPersistedState({
        paths: ['auth']
    })],
})
