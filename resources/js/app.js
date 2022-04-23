require('./bootstrap');
window.Vue = require('vue');

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import store from './store/index.js'

import http_client from './services/http_client';
Vue.prototype.$http = http_client;

import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

// редактор текста
import CKEditor from 'ckeditor4-vue';
Vue.use( CKEditor );


Vue.component('top-menu-component', require('./components/menu/TopMenuComponent').default);
Vue.component('create-vacancy-component', require('./components/vacancy/CreateVacancyComponent').default);
Vue.component('my-vacancy-component', require('./components/vacancy/MyVacancyComponent').default);
Vue.component('office-component', require('./components/private_office/OfficeComponent').default);
Vue.component('search-vacancy', require('./components/vacancy/SearchVacancyComponent').default);

const app = new Vue({
    el: '#app',
    store,
});
