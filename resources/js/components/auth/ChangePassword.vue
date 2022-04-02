<template>
    <div>
        <!-- header modal -->
        <div class="modal-header">
            <h5 class="modal-title" id="authModalTitle">{{ trans('auth','change_password') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- body modal -->
        <div class="block_auth">
            <div class="comment">{{ trans('auth','enter_remember_new_password') }}</div>
            <div class="forms">
                <!-- ФОРМЫ =============================== -->
                <form @submit.prevent="changePassword">
                    <!-- New Password -->
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="text" id="new_password" class="form-control"
                               :class="{'is-invalid': $v.new_password.$error}"
                               v-model="new_password"
                               @input="clearNewPassword($event.target.value)"
                               @blur="$v.new_password.$touch()"
                        >
                        <div class="invalid-feedback" v-if="!$v.new_password.required"> {{ trans('auth','field_not_filled') }} </div>
                        <div class="invalid-feedback" v-if="!$v.new_password.minLength">
                            {{ trans('auth','number_characters') }} {{ new_password.length }} {{ trans('auth','less_needed') }} {{ $v.new_password.$params.minLength.min }}.
                        </div>
                    </div>
                    <button type="submit"
                            :class="{'btn btn-block btn-primary disabled': $v.$invalid, 'btn btn-block btn-primary btn-flat': !$v.$invalid}"
                            :disabled="$v.$invalid"
                    >{{ trans('auth','change_password') }}</button>

                </form>
                <!-- / ФОРМЫ =============================== .prevent-->
            </div>
        </div>
    </div>
</template>

<script>

    import { required, minLength } from 'vuelidate/lib/validators'
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
            async changePassword(){
                let data = {
                    password: this.new_password,
                    code: this.code_change_password,
                };
                try {
                    this.clearInputValue()
                    $('#authModal').modal('toggle')
                    const response = await this.$http.post(`user/change-password`, data);
                    if(this.checkSuccess(response)){
                        location.reload()
                    }
                    else{
                        this.message(response.data.message, 'error', 10000, true);
                    }
                } catch (e) {
                    console.log(e);
                }
            },
        },
        props: [
            'lang',   // масив названий и url языка
            'code_change_password',
        ],
        validations: {
            new_password: {
                required,
                minLength: minLength(6)
            }
        }
    }
</script>

<style scoped>
    .block_auth .comment {
        color: black;
        font-size: 14px;
        margin: 15px 0px;
    }
    .block_auth .footer div {
        margin: 10px 0px;
    }
    .block_auth .forms {
        width: 90%;
    }

</style>
