export default ({
// видимость модалки регистрации и показ нужного варианта рег, авториза, вост пароля
    state:{
        tpMenuVisi: false,
        tpNameComponent: '',
        tpArrayComponent: ['comAuth', 'comSign', 'comResp', 'comChangePassword'],
    },
    // SET this.$store.commit('tpSetComponent', {'a':1})
    mutations: {
        tpSetComponent(state, payload){
            state.tpNameComponent = state.tpArrayComponent[parseInt(payload)]
        },
        tpSetMenuVisi(state){
            state.tpMenuVisi = !state.tpMenuVisi
        }
    },
    // GET this.$store.getters.tpGetMenuVisi
    getters: {
        tpGetComponent(state){
            return state.tpNameComponent
        },
        tpGetMenuVisi(state){
            return state.tpMenuVisi
        }
    },
    actions: {

    }

})
