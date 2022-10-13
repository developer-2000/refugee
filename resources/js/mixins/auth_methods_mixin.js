
export default {
    data() {
        return {
            first_name: '',
            last_name: '',
            email: '',
            password: '',
            new_password: '',
            terms: false,
            uniq_email: true,
        }
    },
    methods: {
        clearEmail(value) {
            this.$store.commit('tpSetEmail', value)
        },
        clearPassword(value) {
            this.password = value.replace(/\s/g,'')
            // this.password = value.replace(/[^A-Za-z0-9@.^_]/g, '')
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

