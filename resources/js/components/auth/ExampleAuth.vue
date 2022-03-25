<template>

    <div class="block_auth">

        <div class="logo">Lucky.com</div>
        <div class="title_auth">Авторизация</div>
        <div class="comment">Войти с помощью</div>
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

        <v-alert :value="true" type="warning" v-if="not_correct !== ''">
            {{ not_correct }}
        </v-alert>

        <div class="forms">
            <!-- ФОРМЫ =============================== -->

            <form @submit.prevent="Auth">

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>


                    <!--                    <input type="email" id="email" class="form-control"-->
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
                    <div class="invalid-feedback" v-if="!$v.email.email"> Email введен не корекно! </div>
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

                <button :class="{'btn grey lighten-1': $v.$invalid, 'btn btn-success': !$v.$invalid}"
                        type="submit"
                        :disabled="$v.$invalid"

                >Войти в систему</button>

            </form>

            <!-- / ФОРМЫ =============================== .prevent-->
        </div>
        <div class="footer">
            <div class="sign">
            Не зарегистрированы ? <a href="#" @click="chengeVal(1)">Зарегистрироваться сейчас.</a>
            </div>
            <div class="resp_pass">
            Забыли свой пароль ? <a href="#" @click="chengeVal(2)">Создать новый пароль.</a>
            </div>
        </div>

    </div>

</template>

<script>

    import { required, minLength, email } from 'vuelidate/lib/validators'

    export default {
        data: function(){
            return {
                email: '',
                password: '',
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
            clearPassword(value) {
                this.password = value.replace(/[^A-Za-z0-9@.^_]/g, '')
            },
            // вариант отображения модалки - высылает родителю значение в виде цифры
            chengeVal: function (a) {
                this.$emit('login', {
                    num: a,
                })
            },
            // авторизация пользователя
            Auth: function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var self = this;

                $.ajax({
                    url: "/auth/login",
                    method: "POST",
                    data: {email: this.email, password: this.password},
                    success: function (response) {
                        var resp = response.msg;

                        if (typeof(resp) !== "undefined") {
                            if (resp === true) {
                                // window.location.replace("/");
                                document.location.reload(true);
                            }
                            else{
                                // показать сообщение
                                self.not_correct = resp
                                setTimeout(() => {
                                    self.not_correct = ''
                                }, 3000)
                            }
                        }
                    }
                });
            }
        },
        validations: {
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(6)
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



    @media only screen and (max-width : 420px) {
        .soc{
            flex-direction: column;
            justify-content: center;
            align-content: flex-start;
            align-items: center;
        }

        .soc a:nth-child(1),
        .soc a:nth-child(2){
            margin-bottom: 10px;
        }
    }




</style>
