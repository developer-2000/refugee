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


// vacancies
Vue.component('edit-vacancy-component', require('./components/vacancy/EditVacancyComponent').default);
Vue.component('my-vacancies-component', require('./components/vacancy/MyVacanciesComponent').default);
Vue.component('bookmark-vacancies-component', require('./components/vacancy/BookmarkVacanciesComponent').default);
Vue.component('hidden-vacancies-component', require('./components/vacancy/HiddenVacanciesComponent').default);
Vue.component('show-vacancy-component', require('./components/vacancy/ShowVacancyComponent').default);
Vue.component('search-vacancy', require('./components/vacancy/SearchVacancyComponent').default);
// resume
Vue.component('edit-resume-component', require('./components/resume/EditResumeComponent').default);
Vue.component('my-resumes-component', require('./components/resume/MyResumesComponent').default);
Vue.component('show-resume-component', require('./components/resume/ShowResumeComponent').default);
Vue.component('bookmark-resumes-component', require('./components/resume/BookmarkResumesComponent').default);
Vue.component('hidden-resumes-component', require('./components/resume/HiddenResumesComponent').default);
Vue.component('search-resumes', require('./components/resume/SearchResumeComponent').default);
// company
Vue.component('edit-company-component', require('./components/company/EditCompanyComponent').default);
Vue.component('company-component', require('./components/company/CompanyComponent').default);
// offer
Vue.component('index-offer-component', require('./components/offer/IndexOfferComponent').default);
Vue.component('show-offer-component', require('./components/offer/ShowOfferComponent').default);
// admin panel
Vue.component('admin-panel', require('./components/admin_panel/AdminPanel').default);
Vue.component('sign-in-component', require('./components/admin_panel/SignInComponent').default);
Vue.component('top-navigation-bar', require('./components/admin_panel/TopNavbar.vue').default);
Vue.component('left_sidebar', require('./components/admin_panel/LeftSidebar.vue').default);
// other
Vue.component('contact_information', require('./components/contact_information/ContactInformationComponent').default);
Vue.component('office-component', require('./components/private_office/OfficeComponent').default);
Vue.component('top-menu-component', require('./components/menu/TopMenuComponent').default);
Vue.component('index-component', require('./components/IndexComponent').default);
Vue.component('main-footer', require('./components/MainFooterComponent').default);
Vue.component('feedback', require('./components/FeedbackComponent').default);
Vue.component('customer_survey', require('./components/customer_survey/CustomerSurveyComponent').default);
Vue.component('show-charity', require('./components/charity/ShowCharityComponent').default);

const app = new Vue({
    el: '#app',
    store,
});
