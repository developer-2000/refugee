require('./bootstrap');
window.Vue = require('vue');

// var Lang = require('lang.js');
// import translations from './vue-translations.js';
// var lang = new Lang();
// lang.setMessages(translations);
// Vue.filter('trans', (...args) => {
//     return lang.get(...args);
// });

Vue.component('top-menu-component', require('./components/menu/TopMenuComponent').default);


const app = new Vue({
    el: '#app',
});
