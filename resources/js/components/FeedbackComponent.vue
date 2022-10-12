<template>
    <div class="container feedback">

        <h1>
            {{trans('pages.feedback','connect_with_us')}}
        </h1>

        <div class="block-body">
            <p>
                {{trans('pages.feedback','fill_out_form')}}
            </p>

            <div class="box-inputs">

                <!-- полное имя -->
                <div class="form-group">
                    <label for="full_name">
                        {{trans('pages.feedback','your_full_name')}}
                        <span class="mandatory-filling">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                    </span>
                    </label>
                    <input type="text" id="full_name" class="form-control" maxlength="100"
                           :placeholder="trans('pages.feedback','enter_your_name')"
                           :class="{'is-invalid': $v.full_name.$error}"
                           v-model="full_name"
                           @blur="$v.full_name.$touch()"
                    >
                    <div class="invalid-feedback" v-if="!$v.full_name.required">
                        {{trans('pages.feedback','please_enter_your_name')}}
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">
                        {{trans('pages.feedback','contact_email')}}
                        <span class="mandatory-filling">
                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                    </span>
                    </label>
                    <input type="email" id="email" class="form-control" maxlength="100"
                           :placeholder="trans('pages.feedback','enter_email')"
                           :class="{'is-invalid': $v.email.$error}"
                           v-model="email"
                           @blur="$v.email.$touch()"
                    >
                    <div class="invalid-feedback" v-if="!$v.email.required">
                        {{trans('pages.feedback','please_enter_your_email')}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.email.email">
                        {{trans('pages.feedback','please_enter_valid_email')}}
                    </div>
                </div>

                <!-- тема сообщения -->
                <div class="form-group">
                    <label for="message_subject">
                        {{trans('pages.feedback','message_subject')}}
                    </label>
                    <select class="form-control" id="message_subject"
                            v-model="message_subject"
                    >
                        <template v-for="(value, key) in respond.config">
                            <option :value="key">
                                {{trans('pages.feedback',key)}}
                            </option>
                        </template>
                    </select>
                </div>

                <!-- текст сообщения -->
                <div class="form-group">
                    <label>
                        {{trans('pages.feedback','message_text')}}
                        <span class="mandatory-filling">
                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                    </span>
                    </label>
                    <ckeditor v-model="objTextarea.message_text"
                              :config="objTextarea.editorConfig1"
                              @input="textareaTouch()"
                    ></ckeditor>
                    <div class="invalid-feedback is-invalid" :class="{' visible': (objTextarea.message_text == '' && bool_touch == true)}" >
                        {{trans('pages.feedback','please_enter_your_message')}}
                    </div>
                </div>

                <!-- отправить -->
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary btn-lg btn-form"
                            :disabled="disableButton($v)"
                            :class="{'disabled': disableButton($v)}"
                            @click.prevent="runCaptcha()"
                    >
                        {{trans('pages.feedback','send_message')}}
                    </button>
                </div>

                <vue-recaptcha
                    ref="recaptcha"
                    size="invisible"
                    :sitekey="respond.captcha_key"
                    @verify="sendMessage"
                    @expired="onCaptchaExpired"
                ></vue-recaptcha>

            </div>
        </div>

        <!-- alert после отправки -->
        <div class="box-alert-exit">

            <div class="alert-exit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"/></svg>
                <br>
                {{trans('pages.feedback','your_message_been_sent')}}
                <br>
                {{trans('pages.feedback','keep_track_specified')}}
                <br>
                {{trans('pages.feedback','thank_you_contacting')}}
            </div>

            <!-- сброс -->
            <button type="submit" class="btn btn-block btn-primary btn-lg"
                    @click.prevent="resetPage()"
            >
                {{trans('pages.feedback','proceed')}}
            </button>

        </div>

    </div>
</template>

<script>

    import translation from "../mixins/translation";
    import {email, required} from "vuelidate/lib/validators";
    import response_methods_mixin from "../mixins/response_methods_mixin";
    import recaptcha_mixin from "../mixins/recaptcha_mixin";

    export default {
        mixins: [
            translation,
            response_methods_mixin,
            recaptcha_mixin
        ],
        data() {
            return {
                full_name: '',
                email: '',
                message_subject: 'main_questions',
                bool_touch: false,
                objTextarea: {
                    message_text: '',
                    editorConfig1: {
                        toolbar: [
                            [ 'Maximize', 'Bold', 'Italic', 'NumberedList', 'BulletedList' ]
                        ],
                    },
                },
            }
        },
        methods: {
            async sendMessage(recaptchaToken) {
                let data = {
                    full_name: this.full_name,
                    email: this.email,
                    subject: this.message_subject,
                    text: this.objTextarea.message_text,
                    captcha_token: recaptchaToken
                }

                $('.btn-form').attr("disabled", true)

                const response = await this.$http.post(this.lang.prefix_lang+"feedback-send-message", data)
                    .then(res => {
                        $('.btn-form').attr("disabled", false)
                        if(this.checkSuccess(res)){
                            $(".block-body").css("display","none")
                            $(".box-alert-exit").css("display","block")
                            this.$v.$reset()
                            this.bool_touch = false
                        }
                        // custom ошибки
                        else{
                            this.message(res.data.message, 'error', 10000, true);
                        }
                    })
                    // ошибки сервера
                    .catch(err => {
                        this.messageError(err)
                        $('.btn-form').attr("disabled", false)
                    })
            },
            disableButton(v) {
                if(v.$invalid || this.objTextarea.message_text == ''){
                    return true;
                }
                return false;
            },
            textareaTouch() {
                this.bool_touch = true
            },
            resetPage() {
                this.insertDefaultValue()
                $(".block-body").css("display","block")
                $(".box-alert-exit").css("display","none")
            },
            insertDefaultValue() {
                this.objTextarea.message_text = ""
                this.message_subject = Object.keys(this.respond.config)[0]
                if(this.respond.contact !== null){
                    this.full_name = this.respond.contact.full_name
                    this.email = this.respond.contact.email
                }
                else{
                    this.full_name = ""
                    this.email = ""
                }
            },
        },
        props: [
            'lang',
            'user',
            'respond',
        ],
        mounted() {
            this.insertDefaultValue()
        },
        validations: {
            full_name: {
                required,
            },
            email: {
                required,
                email,
            },
        },
    }

</script>

<style scoped lang="scss">
    @import "../../sass/variables";

    .feedback{
        padding-bottom: 50px;
    }
    .box-alert-exit{
        display: none;
        width: 60%;
        margin: 50px auto 0 auto;
        .alert-exit{
            text-align: center;
            padding: 40px;
            background: #f3f9ff;
            svg{
                width: 40px;
                fill: #28a745;
                margin-bottom: 20px;
            }
        }
    }
    h1{
        padding: 60px 0 0 !important;
        text-align: center;
    }
    p{
        text-align: center;
    }
    .box-inputs{
        margin: 80px 0 0 0;
    }
    button{
        width: auto;
        margin: 40px auto 0;
    }
    .visible {
        display: block;
    }
    .form-group {
        margin: 0 auto 1rem auto;
        width: 50%;
    }

    @media (max-width: 992px) {
        .form-group {
            width: 70%;
        }
        .box-alert-exit {
            width: 90%;
        }
    }
    @media (max-width: 568px) {
        .form-group {
            width: 90%;
        }

    }

</style>





























