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
            <!-- ФОРМЫ =============================== -->
            <div class="forms">
                <form @submit.prevent="changePassword" action="#">
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
                        <!--valid-feedback-->
                        <input type="hidden" name="token" v-model="x_csrf">
                    </div>

                    <button :class="{'btn btn-block btn-primary disabled': $v.$invalid, 'btn btn-block btn-primary btn-flat': !$v.$invalid}"
                            type="submit"
                            :disabled="$v.$invalid"
                    >{{ trans('auth','email_request') }}</button>
                </form>
            </div>
            <!-- / ФОРМЫ =============================== .prevent-->
        </div>
    </div>
</template>

<script>
    import { required, email } from 'vuelidate/lib/validators'
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
            return {
                x_csrf: $('meta[name="csrf-token"]').attr('content'),
            }
        },
        methods: {
            async changePassword () {
                let data = {
                    email: this.email,
                };
                try {
                    this.clearInputValue()
                    $('#authModal').modal('toggle')
                    const response = await this.$http.post(`user/send-code-password`, data);
                    if(this.checkSuccess(response)){
                        this.message(response.data.message, 'success', 10000, true);
                    }
                } catch (e) {
                    console.log(e);
                }
            }
        },
        props: [
            'lang',   // масив названий и url языка
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
