export default ({

    state:{
        tpEmail: "",
        auth: "",
    },
    // SET this.$store.commit('tpSetComponent', {'a':1})
    mutations: {
        tpSetEmail(state, payload){
            state.tpEmail = payload
        },
        setAuth(state, payload){
            state.auth = payload
        },
    },
    // GET this.$store.getters.tpGetMenuVisi
    getters: {
        tpGetEmail(state){
            return state.tpEmail
        },
        getAuth(state){
            return state.auth
        },
    },
    actions: {

    }

})
