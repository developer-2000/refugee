require('./bootstrap');
window.Vue = require('vue');

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import store from './store/index.js'

import http_client from './services/http_client';
Vue.prototype.$http = http_client;

import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

Vue.component('top-menu-component', require('./components/menu/TopMenuComponent').default);

const app = new Vue({
    el: '#app',
    store,
});
