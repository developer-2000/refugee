<template>
    <!-- регистрация -->
    <div>
        <!-- header modal -->
        <div class="modal-header">
            <h5 class="modal-title" id="authModalTitle">{{ trans('auth','registration') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- body modal -->
        <div class="block_auth">
            <div class="annotation-top">{{ trans('auth','registration_with') }}</div>
            <buttons_social></buttons_social>
            <div class="annotation-bottom"> <span>{{ trans('auth','or') }}</span> </div>
            <div class="forms">
                <!-- ФОРМЫ =============================== -->
                <form @submit.prevent="runCaptcha" action="#">
                    <div class="full-name">
                        <!-- First name -->
                        <div class="form-group">
                            <label for="first_name">{{ trans('auth','first_name') }}</label>
                            <input type="text" id="first_name" class="form-control"
                                   :class="{'is-invalid': $v.first_name.$error}"
                                   v-model="first_name"
                                   @blur="$v.first_name.$touch()"
                            >
                            <div class="invalid-feedback" v-if="!$v.first_name.required"> {{ trans('auth','field_not_filled') }} </div>
                            <div class="invalid-feedback" v-if="!$v.first_name.minLength">
                                {{ trans('auth','number_characters') }} {{ first_name.length }} {{ trans('auth','less_needed') }} {{ $v.first_name.$params.minLength.min }}.
                            </div>
                        </div>
                        <!-- Last name -->
                        <div class="form-group">
                            <label for="last_name">{{ trans('auth','last_name') }}</label>
                            <input type="text" id="last_name" class="form-control"
                                   :class="{'is-invalid': $v.last_name.$error}"
                                   v-model="last_name"
                                   @blur="$v.last_name.$touch()"
                            >
                            <div class="invalid-feedback" v-if="!$v.last_name.required"> {{ trans('auth','field_not_filled') }} </div>
                            <div class="invalid-feedback" v-if="!$v.last_name.minLength">
                                {{ trans('auth','number_characters') }} {{ last_name.length }} {{ trans('auth','less_needed') }} {{ $v.last_name.$params.minLength.min }}.
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">{{$v.$invalid}}
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control"
                               :class="{'is-invalid': $v.email.$error}"
                               v-model="email"
                               @input="clearEmail($event.target.value)"
                               @blur="uniqEmail()"
                        >
                        <div class="invalid-feedback" v-if="!$v.email.required"> {{ trans('auth','field_not_filled') }} </div>
                        <div class="invalid-feedback" v-if="!$v.email.email"> {{ trans('auth','email_not_incorrectly') }} </div>
                        <div class="custom-invalid" :class="{'visible': uniq_email === false}">
                            {{ trans('auth','email_already_registered') }}
                        </div>

                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            type="text"
                            id="password"
                            class="form-control"
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
                    <!-- Соглашение -->
                    <div class="form-check input inline" :class="{invalid: $v.terms.$invalid}">
                        <input type="checkbox" id="terms"
                               class="form-check-input"
                               :class="{'is-invalid': $v.terms.$error}"
                               v-model="terms"
                               @change="$v.terms.$touch()"
                        >
                        <div class="invalid-feedback" v-if="!terms"> {{ trans('auth','field_not_filled') }} </div>
                        <label class="form-check-label">
                            <div class="terms-use">
                                {{ trans('auth','agree_with_that') }}
                                <a href="javascript:void(0)">{{ trans('auth','terms_use') }}</a> {{ trans('auth','and') }} <a href="javascript:void(0)">{{ trans('auth','privacy_policy') }}.</a>
                            </div>
                        </label>
                    </div>

                    <button type="submit"
                            :class="{'btn btn-block btn-primary disabled': $v.$invalid, 'btn btn-block btn-primary btn-flat': !$v.$invalid}"
                            :disabled="$v.$invalid"
                    >{{ trans('auth','registration') }}</button>

                </form>
                <!-- / ФОРМЫ =============================== -->
            </div>
            <div class="footer">
                <div class="login">
                    <a href="javascript:void(0)" @click="changeVal(0)">{{ trans('auth','already_have_account') }} ?</a>
                </div>
            </div>

            <!-- recaptcha -->
            <vue-recaptcha
                v-if="this.$store.getters.ReGetAuth"
                ref="recaptcha_auth"
                size="invisible"
                :sitekey="cap_key"
                @verify="send"
                @expired="onCaptchaExpired"
            ></vue-recaptcha>
        </div>
    </div>
</template>

<script>
    import { required, minLength, email } from 'vuelidate/lib/validators'
    import translation from '../../mixins/translation'
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import auth_methods_mixin from "../../mixins/auth_methods_mixin";
    import buttons_social from "./details/ButtonsSocialComponent";
    import {VueRecaptcha} from "vue-recaptcha";

    export default {
        mixins: [
            translation,
            response_methods_mixin,
            auth_methods_mixin
        ],
        components: {
            'buttons_social': buttons_social,
            VueRecaptcha,
        },
        data: function(){
            return {}
        },
        methods: {
            // высылает родителю значение в виде цифры - отображения модалки (при кликах - авториз или регистрация)
            changeVal: function (a) {
                this.$emit('login', { num: a })
            },
            // регистрация пользователя
            async send(){
                let data = {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    email: this.email,
                    password: this.password,
                }
                try {
                    this.clearInputValue()
                    $('#authModal').modal('toggle')
                    const response = await this.$http.post(this.lang.prefix_lang+"user/registration", data);
                    if(this.checkSuccess(response)){
                        this.message(response.data.message, 'success', 10000, true);
                    }
                } catch (e) {
                    console.log(e);
                }
            },
            async uniqEmail() {
                this.$v.email.$touch()
                let data = {email: this.email}

                if(this.email == ""){
                    this.uniq_email = true
                    return false
                }

                const response = await this.$http.post("/user/check_email", data)
                if(this.checkSuccess(response)){
                    this.uniq_email = response.data.message
                }
            },
            onCaptchaExpired () {
                this.$refs.recaptcha_auth.reset()
            },
            // запускаем каптчу
            runCaptcha () {
                this.$refs.recaptcha_auth.execute()
            },
        },
        props: [
            'lang',
            'cap_key',
        ],
        validations: {
            last_name: {
                required,
                minLength: minLength(3)
            },
            first_name: {
                required,
                minLength: minLength(3)
            },
            email: {
                required,
                email,
            },
            password: {
                required,
                minLength: minLength(6)
            },
            // соглашение
            terms: {
                checked(val) {
                    return val;
                }
            }
        }
    }
</script>

<style scoped lang="scss">

    .custom-invalid{
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #e3342f;
    }
    .visible {
        display: block;
    }
    .block_auth{
        .soc {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-around;
            align-content: stretch;
            align-items: flex-start;
            width: 100%;
            .soc_google, .soc_facebook, .soc_twitter{
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
            .full-name{
                display: flex;
                justify-content: space-between;
                & > div{
                    width: 48%!important;
                }
            }
            .terms-use{
                margin-bottom: -20px;
                color: black;
                font-size: 12px;
            }
            #terms{
                margin-top: 2px;
            }
        }
        .footer {
            color: #BDBDBD;
            width: 90%;
            & > div {
                margin: 10px 0px;
            }
        }
    }
</style>
