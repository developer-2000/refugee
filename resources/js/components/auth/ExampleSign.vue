<template>

    <div class="block_auth">

        <div class="logo">Lucky.com</div>
        <div class="title_auth">Создать акаунт</div>
        <div class="comment">Регистрация с</div>
        <div class="soc">
            <a rel="nofollow" href="#" class="soc_google" data-network="google">
                <img src="//d1ayxb9ooonjts.cloudfront.net/8bc625062aeffa94729b9336243bed9d.svg" alt="Google" width="20">
            </a>
            <a rel="nofollow" href="#" class="soc_facebook" data-network="facebook">
                <img src="//d1ayxb9ooonjts.cloudfront.net/0e5903c8a59540fefb8d56fe51863bb0.svg" alt="facebook"
                     width="20">
            </a>
            <a rel="nofollow" href="#" class="soc_twitter" data-network="twitter">
                <img src="//d3h5jhobc20ump.cloudfront.net/b8221293363ccb5ce7460067acbe55f5.svg" alt="twitter"
                     width="20">
            </a>
        </div>
        <div class="comment">Или же</div>
        <div class="forms">
            <!-- ФОРМЫ =============================== -->

            <v-alert :value="true" type="warning" v-if="not_correct !== ''">
                {{ not_correct }}
            </v-alert>

            <form @submit.prevent="Sign" action="#">

                <!-- Login -->
                <div class="form-group">
                    <label for="login">Login</label>
                    <input type="text" id="login" class="form-control"
                           :class="{'is-invalid': $v.login.$error}"
                           v-model="login"
                           @input="clearLogin($event.target.value)"
                           @blur="$v.login.$touch()"
                    >
                    <div class="invalid-feedback" v-if="!$v.login.required"> Поле не заполнено! </div>
                    <div class="invalid-feedback" v-if="!$v.login.minLength">
                        Кол-во символов {{ login.length }} меньше необходимых {{ $v.login.$params.minLength.min }}.
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <!-- <input type="email" id="email" class="form-control"-->
<!--                           :class="{'is-invalid': $v.email.$error}"-->
<!--                           v-model="email"-->
<!--                           @input="clearEmail($event.target.value)"-->
<!--                           @blur="$v.email.$touch()"-->
<!--                    >-->
                    <input type="email" id="email" class="form-control"
                           :class="{'is-invalid': $v.email.$error}"
                           :value="getEmail()"
                           @input="clearEmail($event.target.value)"
                           @blur="touchEmail()"
                    >


                    <div class="invalid-feedback" v-if="!$v.email.required"> Поле не заполнено! </div>
                    <div class="invalid-feedback" v-if="!$v.email.email"> Email введен не коректно! </div>
<!--                    <div class="invalid-feedback" v-if="!$v.email.uniqEmail">Этот Email уже зарегистрирован!</div>-->
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                            type="password"
                            id="password"
                            class="form-control"
                            :class="{'is-invalid': $v.password.$error}"
                            v-model="password"
                            @input="clearPassword($event.target.value)"
                            @blur="$v.password.$touch()"
                    >
                    <div class="invalid-feedback" v-if="!$v.password.required"> Поле не заполнено! </div>
                    <div class="invalid-feedback" v-if="!$v.password.minLength">
                        Кол-во символов {{ password.length }} меньше необходимых {{ $v.password.$params.minLength.min }}.
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="confirm">Confirm password</label>
                    <input
                            type="password"
                            id="confirm"
                            class="form-control"
                            :class="{'is-invalid': $v.confirmPassword.$error}"
                            v-model="confirmPassword"
                            @input="clearConfirm($event.target.value)"
                            @blur="$v.confirmPassword.$touch()"
                    >
                    <div class="invalid-feedback" v-if="!$v.confirmPassword.required"> Поле не заполнено! </div>
                    <div class="invalid-feedback" v-if="!$v.confirmPassword.sameAs"> Пароли должны соответствовать </div>
                </div>

                <button :class="{'btn grey lighten-1': $v.$invalid, 'btn btn-success': !$v.$invalid}"
                type="submit"
                :disabled="$v.$invalid"
                >Создать акаунт</button>

            </form>

            <!-- / ФОРМЫ =============================== -->
        </div>
        <div class="footer">
            <div class="document">
                При создании учетной записи вы соглашаетесь с
                <a href="#">Условия предоставления услуг</a>
                и
                <a href="#">Политика конфиденциальности.</a>
            </div>
            <div class="login">
                Уже есть учетная запись ? <a href="#" @click="chengeVal(0)">Войти в систему.</a>
            </div>
        </div>

    </div>

</template>

<script>

    import { required, minLength, email, sameAs } from 'vuelidate/lib/validators'


    export default {
        data: function(){
            return {
                login: '',
                email: '',
                password: '',
                confirmPassword: '',
                not_correct: ''
            }
        },
        methods: {
            touchEmail() {
                this.email = this.getEmail()
                this.$v.email.$touch()
            },
            getEmail() {
                return this.$store.getters.tpGetEmail
            },
            // зачистка от запрещенных символов
            clearEmail(value) {
                // this.email = value.replace(/[^A-Za-z0-9@.^_]/g, '')
                this.email = value
                this.$store.commit('tpSetEmail', this.email)
            },
            clearLogin(value) {
                this.login = value.replace(/[^A-Za-z0-9@.^_]/g, '')
            },
            clearPassword(value) {
                this.password = value.replace(/[^A-Za-z0-9@.^_]/g, '')
            },
            clearConfirm(value) {
                this.confirmPassword = value.replace(/[^A-Za-z0-9@.^_]/g, '')
            },
            // высылает родителю значение в виде цифры - отображения модалки (при кликах - авториз или регистрация)
            chengeVal: function (a) {
                this.$emit('login', {
                    num: a,
                })
            },
            // регистрация пользователя
            Sign: function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var self = this

                $.ajax({
                    url     : '/auth/register',
                    type    : 'POST',
                    data    : {login: this.login, email2: this.email, password: this.password},
                    dataType: 'json',
                    success : function ( json ) {

                        self.chengeVal(4) // изменить вид модалки
                    },
                    error: function( error ) {
                        console.log('error1', error)
                        if(error.status === 422) {

                            if (error.responseJSON.errors.email2[0] !== "undefined") {
                                self.not_correct = error.responseJSON.errors.email2[0]
                                setTimeout(() => {
                                    self.not_correct = ''
                                }, 3000)
                            }

                        }
                        else {
                            console.log('error3', error)
                        }
                    }
                });
            }
        },
        validations: {
            login: {
                required,
                minLength: minLength(6)
            },
            email: {
                required,
                email,
                // проверка email на повторение на базе
                // uniqEmail: function(newEmail) {
                //     console.log('tyt 1' , newEmail)
                //
                //     // если поле пустое - не выводи эту ошибку
                //     if (newEmail === '') return true
                //
                //     return new Promise((resolve, reject) => {
                //
                //         $.ajaxSetup({
                //             headers: {
                //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //             }
                //         });
                //         $.ajax({
                //             url: "/auth/check_email",
                //             method: "POST",
                //             data: {email: this.email},
                //             success: function (response) {
                //                 console.log(response)
                //                 if(parseInt(response)){
                //                     resolve(false)
                //                 }
                //                 else{
                //                     resolve(true)
                //                 }
                //             }
                //         });
                //     })
                // }
            },
            password: {
                required,
                minLength: minLength(6)
            },
            confirmPassword: {
                required,
                sameAs: sameAs('password')
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

    .block_auth .comment {
        color: #BDBDBD;
        text-transform: uppercase;
        font-weight: 600;
        font-size: 14px;
        margin: 15px 0px;
    }

    .soc {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: space-around;
        align-content: stretch;
        align-items: flex-start;
        width: 100%;
    }

    .block_auth a.soc_google,
    .block_auth a.soc_facebook,
    .block_auth a.soc_twitter {
        border: 1px solid #4285F4;
        width: 90px;
        background-color: white;
        height: 40px;
        padding: 0;
        line-height: 36px;
        display: inline-block;
        border-radius: 3px;

        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
        justify-content: center;
        align-content: stretch;
        align-items: center;
    }

    .block_auth a.soc_google:hover {
        border-color: #0d43c0;
        background-color: #f9f9f9;
    }

    .block_auth a.soc_facebook {
        border: 1px solid #3C5A99;
    }

    .block_auth a.soc_facebook:hover {
        border-color: #28406a;
        background-color: #f9f9f9;
    }

    .block_auth a.soc_twitter {
        border: 1px solid #16aae5;
    }

    .block_auth a.soc_twitter:hover {
        border-color: #157aa4;
        background-color: #f9f9f9;
    }

    .block_auth .footer {
        color: #BDBDBD;
        width: 90%;
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
    .v-alert.v-alert{
        border: none !important;
    }


</style>
