<template>
<!-- авторизация -->
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
            <buttons_social></buttons_social>
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
                    <a href="javascript:void(0)" @click="chengeVal(1)">{{ trans('auth','not_registered') }} ?</a>
                </div>
                <div class="resp_pass">
                    <a href="javascript:void(0)" @click="chengeVal(2)">{{ trans('auth','forgot_your_password') }} ?</a>
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
    import buttons_social from "./details/ButtonsSocialComponent";

    export default {
        mixins: [
            translation,
            response_methods_mixin,
            auth_methods_mixin
        ],
        components: {
            'buttons_social': buttons_social,
        },
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
                    const response = await this.$http.post(this.lang.prefix_lang+`user/login`, data)
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
