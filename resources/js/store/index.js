import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

import topMenu from './topmenu.js'

export default new Vuex.Store ({
    modules:{
        topMenu: topMenu,
    },
    state:{ },
    getters: { },
    mutations: { },
    actions: { }
})



