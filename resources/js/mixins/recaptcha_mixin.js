import {VueRecaptcha} from "vue-recaptcha";

export default {
    components: {
        VueRecaptcha,
    },
    data() {
        return {
        }
    },
    methods: {
        onCaptchaExpired () {
            this.$refs.recaptcha.reset()
        },
        // запускаем каптчу
        runCaptcha () {
            this.$refs.recaptcha.execute()
        },
    },

}

