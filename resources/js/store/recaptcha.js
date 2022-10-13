export default ({

    state:{
        show_auth: false,
    },
    // SET this.$store.commit('tpSetComponent', {'a':1})
    mutations: {
        ReSetAuth(state, payload){
            state.show_auth = payload
        },
    },
    // GET this.$store.getters.tpGetMenuVisi
    getters: {
        ReGetAuth(state){
            return state.show_auth
        },
    },
    actions: {

    }

})
