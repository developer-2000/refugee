<template>

    <div class="block_auth">

        <div class="logo">Lucky.com</div>
        <div class="title_auth">Востановление пароля</div>

        <div class="comment2">Введите свой Email который используете для входа в Lucky.</div>

        <div class="forms">
            <!-- ФОРМЫ =============================== -->

            <form @submit.prevent="onSubmit" action="#">

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" class="form-control"
                           :class="{'is-invalid': $v.email.$error}"
                           v-model="email"
                           @input="clearEmail($event.target.value)"
                           @blur="$v.email.$touch()"
                    >

                    <div class="invalid-feedback" v-if="!$v.email.required"> Поле не заполнено! </div>
                    <div class="invalid-feedback" v-if="!$v.email.email"> Email введен не корекно! </div>
                    <!--valid-feedback-->
                    <input type="hidden" name="token" v-model="x_csrf">
                </div>

                <button :class="{'btn grey lighten-1': $v.$invalid, 'btn btn-success': !$v.$invalid}"
                        type="submit"
                        :disabled="$v.$invalid"
                >Заменить пароль</button>

            </form>

            <!-- / ФОРМЫ =============================== .prevent-->
        </div>

    </div>

</template>

<script>

    import { required, email } from 'vuelidate/lib/validators'

    export default {
        data: function(){
            return {
                email: '',
                x_csrf: $('meta[name="csrf-token"]').attr('content'),
            }
        },
        methods: {
            clearEmail(value) {
                // this.email = value.replace(/[^A-Za-z0-9@.^_]/g, '')
                this.email = value
            },
            // клик по кнопке сброса пароля
            onSubmit () {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var self = this

                $.ajax({
                    url     : '/password/email',
                    type    : 'POST',
                    data    : {email: this.email, _token: this.x_csrf},
                    // dataType: 'json',
                    success : function ( req ) {

                        // обращение к событию родителя - загрузка компонента сообщения
                        self.$emit('login', { num: 3, })

                        // оповещение - найденный и не найденный email
                        parseInt(req) === 0 ?
                            self.$emit("reset_pass", false) :
                            self.$emit("reset_pass", true);
                    },
                    error: function( json2 ) {
                        console.log(' error 0 ' , json2);
                        if(json2.status === 422) {
                            console.log(' error 1 ' , json2.responseJSON);
                            $.each(json2.responseJSON, function (key, value) {
                                console.log(' error 2 ');
                            });

                        } else {
                            console.log(' error 3 ')
                        }
                    }
                });

            }
        },
        validations: {
            email: {
                required,
                email
            }
        }
    }
</script>


<style scoped>
    .block_auth {
        margin: 0px auto;
        outline: 1px solid black;
        padding: 35px;
        background-color: white;
        cursor: default;

        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
        justify-content: flex-start;
        align-content: stretch;
        align-items: center;
    }

    .block_auth .logo {
        font-size: 26px;
        font-weight: 600;
    }

    .block_auth .title_auth {
        font-size: 26px;
        margin: 20px 0px 5px 0px;
    }

    .block_auth .comment2 {
        color: #BDBDBD;
        font-size: 13px;
        margin: 15px 0px;
    }

    .block_auth .footer div {
        margin: 10px 0px;
    }

    .block_auth .forms {
        width: 90%;
    }
    .block_auth button {
        width: 100%;

        height: 50px;

        font-size: 18px;

        margin: 20px 0px;
    }


</style>
