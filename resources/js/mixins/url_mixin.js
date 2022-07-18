export default {
    data() {
        return {}
    },
    methods: {
        urlNotQuery(){
            return window.location.protocol + '//' + window.location.hostname + window.location.pathname
        },
        urlPathname(){
            return window.location.pathname
        },
    },
}
