import './bootstrap';
import {createApp} from 'vue';
import router from './router';
import store from './store';
import axios from 'axios';
import i18n from "./i18n";
import DefaultComponent from "./components/DefaultComponent";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import VueSimpleAlert from "vue3-simple-alert";
import VueNextSelect from 'vue-next-select';
import 'vue-next-select/dist/index.css';


/* Start tooltip alert code */
const options = {
    timeout: 2000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: true,
    rtl: false
};
/* End tooltip alert code */

/* Start axios code*/
axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
axios.interceptors.request.use(
    config => {
        if(localStorage.getItem('vuex')) {
            const vuex = JSON.parse(localStorage.getItem('vuex'));
            const token = vuex.auth.authToken;
            config.headers.common['Authorization'] = token ? `Bearer ${token}` : '';
        }
        return config;
    },
    error => Promise.reject(error),
);
/* End axios code */

const app = createApp({});
// app.config.productionTip = false;
app.component('default-component', DefaultComponent);
app.component('vue-select', VueNextSelect);
app.use(router);
app.use(store);
app.use(VueSimpleAlert);
app.use(Toast, options);
app.use(i18n);
app.mount('#app');
