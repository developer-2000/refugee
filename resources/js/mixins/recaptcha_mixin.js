
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
            console.log(this.$refs.recaptcha_body)
            this.$refs.recaptcha_body.execute()
        },
    },
}

