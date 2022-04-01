<template>
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

                        <div class="invalid-feedback" v-if="!$v.email.required"> {{ trans('auth','field_not_filled') }} </div>
                        <div class="invalid-feedback" v-if="!$v.email.email"> {{ trans('auth','email_not_incorrectly') }} </div>
                        <!--valid-feedback-->
                        <input type="hidden" name="token" v-model="x_csrf">
                    </div>

                    <button :class="{'btn btn-block btn-primary disabled': $v.$invalid, 'btn btn-block btn-primary btn-flat': !$v.$invalid}"
                            type="submit"
                            :disabled="$v.$invalid"
                    >{{ trans('auth','change_password') }}</button>
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
            // клик по кнопке сброса пароля
            onSubmit () {
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

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

<style scoped>
    .block_auth .comment {
        color: black;
        font-size: 12px;
        margin: 15px 0px;
        padding: 0px 18px;
    }
    .block_auth .footer div {
        margin: 10px 0px;
    }
    .block_auth .forms {
        width: 90%;
    }
    .block_auth button {
        margin: 30px 0px 20px;
    }
</style>
