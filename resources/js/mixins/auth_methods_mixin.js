
export default {
    data() {
        return {
            first_name: '',
            last_name: '',
            email: '',
            password: '',
            new_password: '',
            terms: false
        }
    },
    methods: {
        clearEmail(value) {
            this.email = value
            this.$store.commit('tpSetEmail', this.email)
        },
        clearPassword(value) {
            this.password = value.replace(/[^A-Za-z0-9@.^_]/g, '')
        },
        clearOldPassword(value) {
            this.old_password = value.replace(/[^A-Za-z0-9@.^_]/g, '')
        },
        clearNewPassword(value) {
            this.new_password = value.replace(/[^A-Za-z0-9@.^_]/g, '')
        },
        clearInputValue() {
            this.first_name = ''
            this.last_name = ''
            this.email = ''
            this.password = ''
            this.$v.$reset()
        },
    },

}

