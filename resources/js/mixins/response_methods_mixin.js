import 'sweetalert2/dist/sweetalert2.min.css';

export default {
    data() {
        return {}
    },
    methods: {
        // проверка backup данных axios
        checkSuccess(response) {
            if(response?.data?.status && response.data.status == 200){
                return true;
            }
            else{
                // if(response?.data?.code === 422){
                    this.message(response.data.message, 'error');
                // }
            }
            return false;
        },
        message(msg = '', icon, time = 1500, button_bool = false) {
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

