import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

import topMenu from './topmenu.js'
import avtorisation from './avtorisation.js'
import recaptcha from './recaptcha.js'

export default new Vuex.Store ({
    modules:{
        topMenu: topMenu,
        avtorisation: avtorisation,
        recaptcha: recaptcha,
    },
    state:{ },
    getters: { },
    mutations: { },
    actions: { }
})



