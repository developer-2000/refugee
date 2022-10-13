
export default {
    data() {
        return { }
    },
    methods: {
        onCaptchaExpired () {
            this.$refs.recaptcha_body.reset()
        },
        // запускаем каптчу
        runCaptcha () {
            this.$refs.recaptcha_body.execute()
        },
    },
}

