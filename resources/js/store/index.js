import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

import topMenu from './topmenu.js'
import avtorisation from './avtorisation.js'

export default new Vuex.Store ({
    modules:{
        topMenu: topMenu,
        avtorisation: avtorisation,
    },
    state:{ },
    getters: { },
    mutations: { },
    actions: { }
})



