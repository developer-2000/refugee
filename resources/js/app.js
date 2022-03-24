require('./bootstrap');
window.Vue = require('vue');

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('top-menu-component', require('./components/menu/TopMenuComponent').default);


const app = new Vue({
    el: '#app',
});
