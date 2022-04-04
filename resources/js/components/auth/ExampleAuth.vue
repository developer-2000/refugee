<template>
    <div>
        <!-- header modal -->
        <div class="modal-header">
            <h5 class="modal-title" id="authModalTitle">{{ trans('auth','authorization') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- body modal -->
        <div class="block_auth">
            <div class="annotation-top">{{ trans('auth','authorization_using') }}</div>
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
            <div class="annotation-bottom"> <span>{{ trans('auth','or') }}</span> </div>
            <div class="forms">
                <!-- ФОРМЫ =============================== -->
                <form @submit.prevent="auth">
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control"
                               :class="{'is-invalid': $v.email.$error}"
                               v-model="email"
                               @input="clearEmail($event.target.value)"
                               @blur="$v.email.$touch()"
                        >
                        <div class="invalid-feedback" v-if="!$v.email.required"> {{ trans('auth','field_not_filled') }} </div>
                        <div class="invalid-feedback" v-if="!$v.email.email"> {{ trans('auth','email_not_incorrectly') }} </div>
                    </div>
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" id="password" class="form-control"
                               :class="{'is-invalid': $v.password.$error}"
                               v-model="password"
                               @input="clearPassword($event.target.value)"
                               @blur="$v.password.$touch()"
                        >
                        <div class="invalid-feedback" v-if="!$v.password.required"> {{ trans('auth','field_not_filled') }} </div>
                        <div class="invalid-feedback" v-if="!$v.password.minLength">
                            {{ trans('auth','number_characters') }} {{ password.length }} {{ trans('auth','less_needed') }} {{ $v.password.$params.minLength.min }}.
                        </div>
                    </div>

                    <button type="submit"
                            :class="{'btn btn-block btn-primary disabled': $v.$invalid, 'btn btn-block btn-primary btn-flat': !$v.$invalid}"
                            :disabled="$v.$invalid"
                    >{{ trans('auth','authorization') }}</button>

                </form>
                <!-- / ФОРМЫ =============================== .prevent-->
            </div>
            <div class="footer">
                <div class="sign">
                    <a href="#" @click="chengeVal(1)">{{ trans('auth','not_registered') }} ?</a>
                </div>
                <div class="resp_pass">
                    <a href="#" @click="chengeVal(2)">{{ trans('auth','forgot_your_password') }} ?</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {email, minLength, required} from 'vuelidate/lib/validators'
    import translation from '../../mixins/translation'
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import auth_methods_mixin from "../../mixins/auth_methods_mixin";

    export default {
        mixins: [
            translation,
            response_methods_mixin,
            auth_methods_mixin
        ],
        data: function(){
            return {}
        },
        methods: {
            // вариант отображения модалки - высылает родителю значение в виде цифры
            chengeVal: function (a) {
                this.$emit('login', {
                    num: a,
                })
            },
            // авторизация пользователя
            async auth(){
                let data = {
                    email: this.email,
                    password: this.password,
                };
                try {
                    const response = await this.$http.post(`user/login`, data)
                        .then(res => {
                            if(this.checkSuccess(res)){
                                location.reload()
                            }
                            // custom ошибки
                            else{
                                this.message(res.data.message, 'error', 10000, true);
                            }
                        })
                        // ошибки сервера
                        .catch(err => {
                            this.messageError(err)
                        })

                    // console.log(response)


                } catch (e) {
                    console.log(e);
                }
            },
        },
        props: [
            'lang',   // масив названий и url языка
        ],
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

<style scoped lang="scss">
    .block_auth {
        .soc {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-around;
            align-content: stretch;
            align-items: flex-start;
            width: 100%;

            .soc_google, .soc_facebook, .soc_twitter {
                border: 1px solid #4285F4;
                width: 90px;
                background-color: white;
                height: 40px;
                padding: 0;
                border-radius: 3px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .soc_google:hover {
                border-color: #0d43c0;
                background-color: #f9f9f9;
            }

            .soc_facebook {
                border: 1px solid #3C5A99;

                &:hover {
                    border-color: #28406a;
                    background-color: #f9f9f9;
                }
            }

            .soc_twitter {
                border: 1px solid #16aae5;

                &:hover {
                    border-color: #157aa4;
                    background-color: #f9f9f9;
                }
            }
        }
        .forms {
            width: 90%;

            .full-name {
                display: flex;
                justify-content: space-between;

                & > div {
                    width: 48% !important;
                }
            }

            .terms-use {
                margin-bottom: -20px;
                color: black;
                font-size: 12px;
            }

            #terms {
                margin-top: 2px;
            }
        }
        .footer {
            color: #BDBDBD;
            width: 90%;

            & > div {
                margin: 10px 0px;
            }
            .resp_pass{
                margin-bottom: 20px;
            }
        }
    }
</style>
