import {createStore} from 'vuex';

import {auth} from './modules/auth'
import {institute} from './modules/institute';
import {student} from './modules/student';
import {field} from './modules/field';
import createPersistedState from "vuex-persistedstate";

export default new createStore({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        institute,
        student,
        field,
    },
    plugins: [createPersistedState({
        paths: ['auth']
    })],
})
