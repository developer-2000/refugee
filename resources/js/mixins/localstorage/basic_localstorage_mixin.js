
export default {
    data() {
        return {
            cookie_police: false,
        }
    },
    methods: {
        checkCookiePolice(){
            let value = localStorage.getItem('cookie_police')
            if(value === "true"){
                this.cookie_police = true
            }
        },
        setCookiePolice(){
            this.cookie_police = true
            localStorage.setItem("cookie_police", "true")
        },
    },
    mounted() {
    },
}

