<template>
    <div class="box-page">
        <!-- обратная ссылка -->
        <div class="top-panel bread-top-cabinet">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="m166.5 424.5-143.1-152a23.94 23.94 0 0 1-6.562-16.5 23.94 23.94 0 0 1 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.938 9.688 9.126 10.03 24.38.938 33.94l-128.4 135.5 128.4 135.5c9.094 9.562 8.75 24.75-.938 33.94-9.53 9.058-24.73 8.658-33.93-.942z"/></svg>
            <a :href="`${lang.prefix_lang}private-office`">
                {{trans('menu.menu','cabinet')}}
            </a>
            <span class="bread-slash"> | </span>
        </div>
        <!-- title -->
        <h1 class="title_page card-body">
            Заполнить контактную информацию
        </h1>
        <!-- desc page -->
        <div class="desc-helper-italic">
            {{trans('company','about_company')}}
        </div>

        <!-- первый row -->
        <div class="row">
            <div class="col-sm-4">
                <!-- имя -->
                <div class="form-group">
                    <label for="name">
                        Ваше имя
                        <span class="mandatory-filling">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                    </label>
                    <input type="text" id="name" class="form-control" maxlength="100" autocomplete="off"
                           placeholder="Ввести имя"
                           :class="{'is-invalid': $v.name.$error}"
                           v-model="name"
                           @blur="$v.name.$touch()"
                    >
                    <div class="invalid-feedback" v-if="!$v.name.required">
                        Пожалуста введите ваше имя
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- фамилия -->
                <div class="form-group">
                    <label for="surname">
                        Ваша фамилия
                        <span class="mandatory-filling">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                    </label>
                    <input type="text" id="surname" class="form-control" maxlength="100" autocomplete="off"
                           placeholder="Ввести фамилию"
                           :class="{'is-invalid': $v.surname.$error}"
                           v-model="surname"
                           @blur="$v.surname.$touch()"
                    >
                    <div class="invalid-feedback" v-if="!$v.surname.required">
                        Пожалуста введите вашу фамилию
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- Должность -->
                <div class="form-group">
                    <label for="position">
                        Должность
                    </label>
                    <input type="text" id="position" class="form-control" maxlength="100" autocomplete="off"
                           placeholder="Ввести должность"
                           v-model="position"
                    >
                </div>
            </div>
        </div>

        <!-- второй row -->
        <div class="row">
            <div class="col-sm-6">
                <!-- email -->
                <div class="form-group">
                    <label for="email">
                        Электронная почта
                        <span class="mandatory-filling">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                    </label>
                    <input type="email" id="email" class="form-control" maxlength="100" autocomplete="off"
                           placeholder="Ввести email"
                           :class="{'is-invalid': $v.email.$error}"
                           v-model="email"
                           @blur="$v.email.$touch()"
                    >
                    <div class="invalid-feedback" v-if="!$v.email.required">
                        Пожалуста введите электронную почту
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <!-- Skype -->
                <div class="form-group">
                    <label for="skype">
                        Skype
                    </label>
                    <input type="text" id="skype" class="form-control" maxlength="100" autocomplete="off"
                           placeholder="Ввести skype"
                           v-model="skype"
                    >
                </div>
            </div>
        </div>

        <!-- третий row -->
        <div class="row">
            <div class="col-sm-12 telephone">
                <!-- Telephone -->
                <div class="form-group">
                    <div class="box-left-right">
                        <div class="left-phone">
                            <!-- title -->
                            <label>
                                Телефон
                                <span class="mandatory-filling">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M489.1 363.3l-24.03 41.59c-6.635 11.48-21.33 15.41-32.82 8.78l-129.1-74.56V488c0 13.25-10.75 24-24.02 24H231.1c-13.27 0-24.02-10.75-24.02-24v-148.9L78.87 413.7c-11.49 6.629-26.19 2.698-32.82-8.78l-24.03-41.59c-6.635-11.48-2.718-26.14 8.774-32.77L159.9 256L30.8 181.5C19.3 174.8 15.39 160.2 22.02 148.7l24.03-41.59c6.635-11.48 21.33-15.41 32.82-8.781l129.1 74.56L207.1 24c0-13.25 10.75-24 24.02-24h48.04c13.27 0 24.02 10.75 24.02 24l.0005 148.9l129.1-74.56c11.49-6.629 26.19-2.698 32.82 8.78l24.02 41.59c6.637 11.48 2.718 26.14-8.774 32.77L352.1 256l129.1 74.53C492.7 337.2 496.6 351.8 489.1 363.3z"/></svg>
                        </span>
                            </label>
                            <!-- view -->
                            <div class="view-phone">
                                {{telObj.view_phone}}
                            </div>
                            <!-- inputs -->
                            <div class="box-input-tel">
                                <!-- Код страны и региона -->
                                <span class="minus-tel">+</span>
                                <div class="box-prefix-tel code_country">
                                    <label for="code_country" class="target-label">
                                        Код страны
                                    </label>
                                    <input type="text" id="code_country" class="form-control" maxlength="100" autocomplete="off"
                                           placeholder="Ввести код"
                                           :class="{'is-invalid': !checkingInteger(telObj.code_country) && telObj.bool_target_input}"
                                           @keyup="enterCodeTelephon($event.target.value, 'code_country')"
                                    >
                                </div>

                                <!-- Код оператора -->
                                <span class="minus-tel">(</span>
                                <div class="box-prefix-tel operator_code">
                                    <label for="operator_code" class="target-label">
                                        Код оператора
                                    </label>
                                    <input type="text" id="operator_code" class="form-control" maxlength="100" autocomplete="off"
                                           placeholder="Ввести код"
                                           :class="{'is-invalid': !checkingInteger(telObj.operator_code) && telObj.bool_target_input}"
                                           @keyup="enterCodeTelephon($event.target.value, 'operator_code')"
                                    >
                                </div>
                                <span class="minus-tel">)</span>

                                <!-- Номер телефона -->
                                <div class="box-prefix-tel phone_number">
                                    <label for="phone_number" class="target-label">
                                        Номер телефона
                                    </label>
                                    <input type="text" id="phone_number" class="form-control" maxlength="100" autocomplete="off"
                                           placeholder="Ввести телефон"
                                           :class="{'is-invalid': !checkingInteger(telObj.phone_number) && telObj.bool_target_input}"
                                           @keyup="enterCodeTelephon($event.target.value, 'phone_number')"
                                    >
                                </div>
                            </div>
                            <!-- error -->
                            <div class="invalid-feedback" v-if="telObj.bool_target_input && !telObj.bool_all_filled">
                                Пожалуста введите номер контактного телефона в международном формате
                            </div>
                        </div>

                        <div class="right-phone">
                            <label>
                                Месенджеры связи этого номера
                            </label>
                            <div>
                                <input class="form-check-input" name="checkbox-messenger" type="checkbox"
                                       id="checkbox-messenger_0"
                                       @change="checkboxMessenger"
                                       value=0
                                >
                                <label for="checkbox-messenger_0" class="target-label">
                                    Telegram
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" name="checkbox-messenger" type="checkbox"
                                       id="checkbox-messenger_1"
                                       @change="checkboxMessenger"
                                       value=1
                                >
                                <label for="checkbox-messenger_1" class="target-label">
                                    Viber
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" name="checkbox-messenger" type="checkbox"
                                       id="checkbox-messenger_2"
                                       @change="checkboxMessenger"
                                       value=2
                                >
                                <label for="checkbox-messenger_2" class="target-label">
                                    WhatsApp
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    import {email, required} from 'vuelidate/lib/validators'
    import translation from "../../mixins/translation";
    import response_methods_mixin from "../../mixins/response_methods_mixin";
    import general_functions_mixin from "../../mixins/general_functions_mixin";

    export default {
        mixins: [
            translation,
            response_methods_mixin,
            general_functions_mixin,
        ],
        data() {
            return {
                name:'',
                surname:'',
                position:'',
                email:'',
                skype:'',
                telObj:{
                    code_country: '',
                    operator_code: '',
                    phone_number: '',
                    view_phone: "+...(...).......",
                    checkbox_messenger: [],
                    bool_target_input: false,
                    bool_all_filled: true,
                },
            }
        },
        methods: {
            enterCodeTelephon(value, variable){
                this.telObj.bool_target_input = true
                this.telObj.bool_all_filled = true
                this.telObj[variable] = value
                this.telObj.bool_error = this.checkingInteger(value)

                // отображение номера
                if(!this.telObj.bool_error){
                    this.telObj.view_phone = "+...(...)......."
                }
                else{
                    this.telObj.view_phone = "+"+this.telObj.code_country+"("+this.telObj.operator_code+")"+this.telObj.phone_number
                }
                // проверка заполнености всех input
                if(!this.checkingInteger(this.telObj.code_country) || !this.checkingInteger(this.telObj.operator_code) || !this.checkingInteger(this.telObj.phone_number)){
                    this.telObj.bool_all_filled = false
                }
            },
            checkboxMessenger(){
                let checked = document.querySelectorAll('[name="checkbox-messenger"]:checked');
                let selected = [];
                for (let i=0; i<checked.length; i++) {
                    selected.push(checked[i].value);
                }
                this.telObj.checkbox_messenger = selected;
            },
        },
        computed: {
        },
        props: [
            'lang',
        ],
        mounted() {
        },
        validations: {
            name: {
                required,
            },
            surname: {
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
    @import "../../../sass/variables";

    .form-group {
        padding: 5px 10px 15px;
        background: #ededed;
        position: relative;
        .invalid-feedback {
            margin-bottom: -13px;
            padding: 3px 0px 1px 0px;
        }
    }
    .telephone{
        .box-left-right{
            display: flex;
            .left-phone{
                width: 50%;
                .box-input-tel{
                    display: flex;
                    align-items: flex-end;

                    .minus-tel{
                        line-height: 38px;
                    }
                    .code_country,
                    .operator_code{
                        margin: 0 10px;
                    }
                    .phone_number{
                        margin-left: 10px;
                    }
                    .box-prefix-tel{
                        #code_country,
                        #phone_number,
                        #operator_code{
                            width: 140px;
                        }
                    }
                }
            }
            .right-phone{
                width: 50%;
            }
        }

        .invalid-feedback {
            display: block;
        }
        .view-phone{
            border-bottom: 1px dashed #444;
            width: 160px;
            margin-bottom: 10px;
        }
    }
    .target-label {
        color: #035ba4;
        font-weight: 500 !important;
        cursor: pointer;
    }



</style>





























