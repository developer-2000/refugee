require('./bootstrap');
window.Vue = require('vue');

import store from './store/index.js'

Vue.component('top-menu-component', require('./components/menu/TopMenuComponent').default);


const app = new Vue({
    el: '#app',
    store,
});
