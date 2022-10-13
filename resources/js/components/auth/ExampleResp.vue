<template>
<!-- востановление пароля -->
    <div>
        <!-- header modal -->
        <div class="modal-header">
            <h5 class="modal-title" id="authModalTitle">{{ trans('auth','password_recovery') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- body modal -->
        <div class="block_auth">
            <div class="comment">{{ trans('auth','enter_mail_use_authorization') }}.</div>
            <div class="forms">
                <form @submit.prevent="runCaptcha" action="#">
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

                    <button :class="{'btn btn-block btn-primary disabled': $v.$invalid, 'btn btn-block btn-primary btn-flat': !$v.$invalid}"
                            type="submit"
                            :disabled="$v.$invalid"
                    >{{ trans('auth','email_request') }}</button>
                </form>
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
    import { required, email } from 'vuelidate/lib/validators'
    import translation from '../../mixins/translation'
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import auth_methods_mixin from "../../mixins/auth_methods_mixin";
    import {VueRecaptcha} from "vue-recaptcha";

    export default {
        components: {
            VueRecaptcha,
        },
        mixins: [
            translation,
            response_methods_mixin,
            auth_methods_mixin
        ],
        data: function(){
            return { }
        },
        methods: {
            async send () {
                let data = {
                    email: this.email,
                };
                try {
                    const response = await this.$http.post(this.lang.prefix_lang+"user/send-code-password", data);
                    if(this.checkSuccess(response)){
                        $('#authModal').modal('toggle')
                        this.clearInputValue()
                        this.message(response.data.message, 'success', 10000, true);
                    }
                    // custom ошибки
                    else{
                        this.message(response.data.message, 'error', 10000, true);
                    }
                } catch (e) {
                    console.log(e);
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
            email: {
                required,
                email
            }
        }
    }
</script>

<style scoped lang="scss">
    .block_auth{
        .comment {
            color: black;
            font-size: 12px;
            margin: 15px 0px;
            padding: 0px 18px;
        }
        .forms {
            width: 90%;
        }
    }
</style>
