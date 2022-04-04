import 'sweetalert2/dist/sweetalert2.min.css';

export default {
    data() {
        return {}
    },
    methods: {
        // проверка backup данных axios
        checkSuccess(response) {
            if(response?.data?.status && response.data.status == 'success'){
                return true;
            }
            return false;
        },
        message(msg = '', icon, time = 3000, button_bool = false) {
            const Toast = this.$swal.mixin({
                toast: true,
                position: 'top',
                timer: time,
                showConfirmButton: button_bool,
                confirmButtonColor: '#3085d6',
            });
            Toast.fire({
                icon: icon,
                title: msg
            })
        },
        messageError(err, msg = '') {
            if (err.response) {
                msg = (err.response.status == 422) ? 'account does not exist' : ''
            } else if (err.request) {
                msg = err.request.statusText
            } else {
                msg = err
            }
            const Toast = this.$swal.mixin({
                toast: true,
                position: 'top',
                timer: 3000,
                showConfirmButton: false,
                confirmButtonColor: '#3085d6',
            });
            Toast.fire({
                icon: 'error',
                title: msg
            })
        },
        // confirm сообщение на странице
        confirmMessage(msg = '', icon, id) {
            this.$swal({
                title: '',
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteWord(id);
                }
            })
        },
    },

}

