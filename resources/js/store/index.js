import {createStore} from 'vuex';

import {auth} from './modules/auth'
import {institute} from './modules/institute';
import createPersistedState from "vuex-persistedstate";

export default new createStore({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        institute,
    },
    plugins: [createPersistedState({
        paths: ['auth']
    })],
})
